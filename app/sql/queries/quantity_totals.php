<?php

include_once(app_path().'/sql/helpers/paginate.php');
include_once(app_path().'/sql/helpers/on.php');
include_once(app_path().'/sql/queries/all_time_totals.php');
include_once(app_path().'/sql/queries/import_totals.php');

use App\Models\ProductMove;
use Illuminate\Support\Facades\DB;




function select_totals_by_month(&$query, $quantity_or_cost) {
    for ($i=1; $i<13; $i++) {$query = $query->selectRaw(/**@lang SQL*/"
        Sum(
            If(month(date) = $i,
                If(this.product_move_type in ('purchasing', 'inventory'), $quantity_or_cost, -$quantity_or_cost),
                0
        )) + Ifnull(import_totals.month_{$i}_totals, 0) As month_{$i}_totals
    ");}

    return $query;
}


function quantity_totals(bool $is_cost_report, ?int $report_storage_id, ?int $report_year) {
    if ($report_storage_id === null or $report_year === null) { return null; }
    $quantity_or_cost = ['quantity', 'quantity*price'][$is_cost_report];
    $import_totals = import_totals($report_storage_id, $quantity_or_cost, $report_year);
    $all_time_totals = all_time_totals($report_storage_id, $quantity_or_cost);

    $totals = DB::table('product_moves as this')
        ->where('this.storage_id', '=', $report_storage_id)
        ->where(DB::raw('year(this.date)'), '=', $report_year)
        ->leftJoinSub($import_totals, 'import_totals', on('this.product_id', '=', 'import_totals.product_id'))
        ->leftJoinSub($all_time_totals, 'all_time_totals', on('this.product_id', '=', 'all_time_totals.product_id'))
        ->groupBy('this.product_id')

        ->selectRaw(/**@lang SQL*/"
            (Select name From products Where id = this.product_id) As product_name,
            Ifnull(all_time_totals.all_time_totals, 0) + Ifnull(import_totals.all_totals, 0) as all_time_totals,
            Sum(If(this.product_move_type In ('purchasing', 'inventory'), $quantity_or_cost, -$quantity_or_cost))
                + Ifnull(import_totals.year_totals, 0) As year_totals");
            select_totals_by_month($totals, $quantity_or_cost);

    return ProductMove::query()->fromSub($totals, 'some_name');
}
