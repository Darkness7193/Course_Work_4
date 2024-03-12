<?php

include_once(app_path().'/helpers/eloquent/paginate.php');

use App\Models\Storage;
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


function inner_import($report_storage_id, $quantity_or_cost) {
    $inner_import = DB::table('product_moves')
        ->where('product_move_type', '=', 'transfering')
        ->where('new_storage_id', '=', $report_storage_id)
        ->groupBy('product_id')

        ->select('product_id')
        ->selectRaw("Sum($quantity_or_cost) As all_totals");
        for ($i=1; $i<13; $i++) {$inner_import = $inner_import->selectRaw(/**@lang SQL*/"
            Sum(If(product_move_type = 'transfering' And month(date) = $i, $quantity_or_cost, 0)) As month_{$i}_totals
        ");}

    return $inner_import;
}


function select_totals_by_month(&$query, $quantity_or_cost) {
    for ($i=1; $i<13; $i++) {$query = $query->selectRaw(/**@lang SQL*/"
        Sum(
            If(month(date) = $i,
                If(this.product_move_type in ('purchasing', 'inventory'), $quantity_or_cost, -$quantity_or_cost),
                0
        )) + Ifnull(inner_import.month_{$i}_totals, 0) As month_{$i}_totals
    ");}

    return $query;
}


function query_totals_of($request, bool $is_cost_report, ?int $report_storage_id, ?int $year) {
    if ($is_cost_report === null or $report_storage_id === null or $year === null) {
        $arr = [];
        return paginate_array($arr, 1); }
    $quantity_or_cost = ['quantity', 'quantity*price'][$is_cost_report];
    $inner_import = inner_import($report_storage_id, $quantity_or_cost);
    $all_time_totals = all_time_totals($report_storage_id, $quantity_or_cost);

    dump($inner_import->get()->toArray());
    $totals = DB::table('product_moves as this')
        ->leftJoinSub($inner_import, 'inner_import', on('this.product_id', '=', 'inner_import.product_id'))
        ->leftJoinSub($all_time_totals, 'all_time_totals', on('this.product_id', '=', 'all_time_totals.product_id'))
        ->where('this.storage_id', '=', $report_storage_id)
        ->where(DB::raw('year(this.date)'), '=', $year)
        ->groupBy('this.product_id')

        ->selectRaw(/**@lang SQL*/"
            (Select name From products Where id = this.product_id) As product_name,
            Ifnull(all_time_totals, 0) + Ifnull(inner_import.all_totals, 0) as all_time_totals,
            Sum(If(this.product_move_type In ('purchasing', 'inventory'), $quantity_or_cost, -$quantity_or_cost))
                + Ifnull(inner_import.all_totals, 0) As year_totals");
            select_totals_by_month($totals, $quantity_or_cost);


    return paginate($totals,
        per_page: session()->get('per_page') ?? 10,
        current_page: $request->current_page ?? 1,
    );
}
