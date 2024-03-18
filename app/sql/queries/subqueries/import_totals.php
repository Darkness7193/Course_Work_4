<?php

use Illuminate\Support\Facades\DB;




function import_totals($report_storage_id, $is_cost_report, $report_year) {
    $quantity_or_cost = $is_cost_report ? 'quantity*price' : 'quantity';

    $import_totals = $q = DB::table('product_moves')
        ->where('product_move_type', '=', 'transfering')
        ->where('new_storage_id', '=', $report_storage_id)
        ->groupBy('product_id')

        ->select('product_id')
        ->selectRaw("Sum($quantity_or_cost) As all_totals")
        ->selectRaw("Sum(If(year(date) = $report_year, $quantity_or_cost, 0)) As year_totals");
        for ($i=1; $i<13; $i++) {$q = $q->selectRaw(/**@lang SQL*/"
            Sum(If(product_move_type = 'transfering' And month(date) = $i, $quantity_or_cost, 0)) As month_{$i}_totals
        ");}

    return $import_totals;
}
