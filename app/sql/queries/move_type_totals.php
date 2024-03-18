<?php

//namespace App\sql\queries;

include_once(app_path().'/sql/helpers/paginate.php');
include_once(app_path().'/sql/helpers/on.php');

use App\Models\ProductMove;
use Illuminate\Support\Facades\DB;




function all_time_totals_2($report_move_type, $report_storage_id, $is_cost_report) {
    $quantity_or_cost = $is_cost_report ? 'quantity*price' : 'quantity';

    return DB::table('product_moves')
        ->where('product_move_type', '=', $report_move_type)
        ->where('storage_id', '=', $report_storage_id)
        ->groupBy('product_id')

        ->select('product_id As product_id')
        ->selectRaw("Sum($quantity_or_cost) As all_time_totals");
}


function move_type_totals($report_move_type, ?int $report_storage_id, ?int $report_year, bool $is_cost_report) {
    if ($report_storage_id === null or $report_year === null) { return null; }
    $quantity_or_cost = $is_cost_report ? 'this.quantity*this.price' : 'this.quantity';

    $totals = $q = DB::table('product_moves as this')
        ->where('product_move_type', '=', $report_move_type)
        ->where('this.storage_id', '=', $report_storage_id)
        ->where(DB::raw('year(this.date)'), '=', $report_year)

        ->leftJoinSub(all_time_totals_2($report_move_type, $report_storage_id, $is_cost_report), 'all_time_totals',
            on('this.product_id', '=', 'all_time_totals.product_id'))

        ->groupBy('this.product_id')
        ->selectRaw("(Select name From products Where id = this.product_id) As product_name")
        ->selectRaw(/**@lang SQL*/"
            Ifnull(all_time_totals.all_time_totals, 0) As all_time_totals,
            Sum($quantity_or_cost) As year_totals");
            for ($i=1; $i<13; $i++) {$q=$q
                ->selectRaw("Sum(If(month(date) = $i, $quantity_or_cost, 0)) As month_{$i}_totals"); }

    return ProductMove::query()->fromSub($totals, 'some_name');
}
