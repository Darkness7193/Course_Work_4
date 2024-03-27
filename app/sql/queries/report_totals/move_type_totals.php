<?php

namespace App\sql\queries\move_type_totals;

include_once(app_path().'/sql/helpers/paginate.php');
include_once(app_path().'/sql/helpers/on.php');

use App\Models\ProductMove;
use Illuminate\Support\Facades\DB;




function move_type_totals($report_move_type, ?int $report_storage_id, ?int $report_year, bool $is_cost_report) {
    if ($report_storage_id === null or $report_year === null) { return ProductMove::first()->where('id', '=', 'asdf'); }
    $quantity_or_cost = $is_cost_report ? 'this.quantity*this.price' : 'this.quantity';

    $totals = $q = DB::table('product_moves as this')
        ->where('product_move_type', '=', $report_move_type)
        ->where('this.storage_id', '=', $report_storage_id)
        ->where(DB::raw('year(this.date)'), '=', $report_year)

        ->groupBy('this.product_id')
        ->selectRaw("(Select name From products Where id = this.product_id) As product_name")
        ->selectRaw(/**@lang SQL*/"
            Sum($quantity_or_cost) As year_totals");
            for ($i=1; $i<13; $i++) {$q=$q
                ->selectRaw("Sum(If(month(date) = $i, $quantity_or_cost, 0)) As month_{$i}_totals"); }

    return ProductMove::query()->fromSub($totals, 'some_name');
}
