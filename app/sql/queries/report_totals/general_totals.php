<?php

include_once(app_path().'/sql/helpers/paginate.php');

use App\Models\ProductMove;
use Illuminate\Support\Facades\DB;


function general_totals($report_storage_id, $begin_date, $end_date, $is_cost_report) {
    if ($report_storage_id === null) { return ProductMove::first()->where('id', '=', 'asdf'); }
    $quantity_or_cost = $is_cost_report ? 'quantity*price' : 'quantity';

    $general_totals = DB::table('product_moves')
        ->where('storage_id', '=', $report_storage_id)
        ->when($begin_date, function($query) use($begin_date, $end_date) {
            $query->whereBetween(DB::raw('year(date)'), [$begin_date, $end_date]); })
        ->groupBy('storage_id', 'product_id')

        ->selectRaw(/**@lang SQL*/"
            (Select name From products Where id = product_id) As product_name,
            sum(if(product_move_type In ('purchasing', 'inventory'), $quantity_or_cost, -$quantity_or_cost)) As quantity_totals,
            sum(if(product_move_type = 'purchasing', $quantity_or_cost, 0)) As purchases_totals,
            sum(if(product_move_type = 'selling', $quantity_or_cost, 0)) As sales_totals,
            sum(if(product_move_type = 'liquidating', $quantity_or_cost, 0)) As liquidating_totals,
            sum(if(product_move_type = 'inventory', $quantity_or_cost, 0)) As inventory_totals,
            sum(if(product_move_type = 'transfering', $quantity_or_cost, 0)) As import_totals
        ");

    return ProductMove::query()->fromSub($general_totals, 'some_name');
}
