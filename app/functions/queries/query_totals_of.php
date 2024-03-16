<?php

include_once(app_path().'/helpers/eloquent/paginate.php');

use App\Models\ProductMove;
use Illuminate\Support\Facades\DB;


function on($value_1, $operator, $value_2) {
    return function($join) use($value_1, $operator, $value_2) {$join->on($value_1, $operator, $value_2); };
}


function all_time_totals($report_storage_id, $quantity_or_cost) {
    return DB::table('product_moves')
        ->where('storage_id', '=', $report_storage_id)
        ->groupBy('product_id')

        ->select('product_id As product_id')
        ->selectRaw("Sum(If(product_move_type In ('purchasing', 'inventory'), $quantity_or_cost, -$quantity_or_cost)) As all_time_totals");
}


function imported($report_storage_id, $quantity_or_cost, $year) {
    $imported = DB::table('product_moves')
        ->where('product_move_type', '=', 'transfering')
        ->where('new_storage_id', '=', $report_storage_id)
        ->groupBy('product_id')

        ->select('product_id')
        ->selectRaw("Sum($quantity_or_cost) As all_totals")
        ->selectRaw("Sum(If(year(date) = $year, $quantity_or_cost, 0)) As year_totals");
        for ($i=1; $i<13; $i++) {$imported = $imported->selectRaw(/**@lang SQL*/"
            Sum(If(product_move_type = 'transfering' And month(date) = $i, $quantity_or_cost, 0)) As month_{$i}_totals
        ");}

    return $imported;
}


function select_totals_by_month(&$query, $quantity_or_cost) {
    for ($i=1; $i<13; $i++) {$query = $query->selectRaw(/**@lang SQL*/"
        Sum(
            If(month(date) = $i,
                If(this.product_move_type in ('purchasing', 'inventory'), $quantity_or_cost, -$quantity_or_cost),
                0
        )) + Ifnull(imported.month_{$i}_totals, 0) As month_{$i}_totals
    ");}

    return $query;
}


function query_totals_of($request, bool $is_cost_report, ?int $report_storage_id, ?int $year) {
    if ($is_cost_report === null or $report_storage_id === null or $year === null) {
        return null; }
    $quantity_or_cost = ['quantity', 'quantity*price'][$is_cost_report];
    $imported = imported($report_storage_id, $quantity_or_cost, $year);
    $all_time_totals = all_time_totals($report_storage_id, $quantity_or_cost);

    $totals = ProductMove::from('product_moves as this')
        ->where('this.storage_id', '=', $report_storage_id)
        ->where(DB::raw('year(this.date)'), '=', $year)
        ->leftJoinSub($imported, 'imported', on('this.product_id', '=', 'imported.product_id'))
        ->leftJoinSub($all_time_totals, 'all_time_totals', on('this.product_id', '=', 'all_time_totals.product_id'))
        ->groupBy('this.product_id')

        ->selectRaw(/**@lang SQL*/"
            (Select name From products Where id = this.product_id) As product_name,
            Ifnull(all_time_totals.all_time_totals, 0) + Ifnull(imported.all_totals, 0) as all_time_totals,
            Sum(If(this.product_move_type In ('purchasing', 'inventory'), $quantity_or_cost, -$quantity_or_cost))
                + Ifnull(imported.year_totals, 0) As year_totals");
            select_totals_by_month($totals, $quantity_or_cost);

    return DB::query()->fromSub($totals, 'some_name');
}
