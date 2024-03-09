<?php

include_once(app_path().'/helpers/eloquent/paginate.php');

use App\Models\Storage;
use Illuminate\Support\Facades\DB;


function on($value_1, $operator, $value_2) {
    return function($join) use($value_1, $operator, $value_2) {$join->on($value_1, $operator, $value_2); };
}


function select_totals_by_months(&$query, $calculated_field) {
    for ($i=1; $i<13; $i++) {
        $query = $query->selectRaw("
            Sum(
                If(month(date) = $i,
                    If(product_move_type In ('purchasing', 'inventory'), $calculated_field, -$calculated_field),
                    0
            )) As month_{$i}_totals
        ");
    }

    return $query;
}


function transfered($report_storage_id, $report_field) {
    return DB::table('product_moves')
        ->where('storage_id', '=', $report_storage_id)
        ->where('product_move_type', '=', 'transfering')
        ->groupBy('product_id')
        ->select('product_id As transfered_product_id')
        ->selectRaw("Sum($report_field) As transfered_totals");
}


function ever($report_storage_id, $report_field) {
    return DB::table('product_moves')
        ->where('storage_id', '=', $report_storage_id)
        ->where('product_move_type', '=', 'transfering')
        ->groupBy('product_id')
        ->select('product_id As ever_product_id')
        ->selectRaw("Sum(If(product_move_type In ('purchasing', 'inventory'), $report_field, -$report_field)) As ever_totals");
}


function query_quantity_or_cost_totals($request, $report_field_i, $report_storage_id, $year) {
    $report_storage_id = $report_storage_id ?: Storage::first()->id;
    $report_field = ['quantity', 'quantity*price'][$report_field_i];
    $transfered = transfered($report_storage_id, $report_field);
    $ever = ever($report_storage_id, $report_field);

    $totals = DB::table('product_moves as this')
        ->joinSub($transfered, 'transfered', on('this.product_id', '=', 'transfered_product_id'))
        ->joinSub($ever, 'ever', on('this.product_id', '=', 'ever_product_id'))
        ->where('this.storage_id', '=', $report_storage_id)
        ->where(DB::raw('year(date)'), '=', $year)
        ->groupBy('this.product_id')
        ->selectRaw("ever_totals,
            (Select name From products Where id = product_id) As product_name,
            Sum(If(product_move_type IN ('purchasing', 'inventory'), $report_field, -$report_field)) - transfered_totals As year_totals");
        select_totals_by_months($totals, $report_field);

    return paginate($totals,
        per_page: $request->session()->get('per_page') ?? 10,
        current_page: $request->current_page ?? 1,
    );
}

