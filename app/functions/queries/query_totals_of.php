<?php

include_once(app_path().'/helpers/eloquent/paginate.php');

use App\Models\Storage;
use Illuminate\Support\Facades\DB;


function on($value_1, $operator, $value_2) {
    return function($join) use($value_1, $operator, $value_2) {$join->on($value_1, $operator, $value_2); };
}


function all_time_totals($report_storage_id, $report_field) {
    return DB::table('product_moves')
        ->where('storage_id', '=', $report_storage_id)
        ->where('product_move_type', '=', 'transfering')
        ->groupBy('product_id')
        ->select('product_id As product_id')
        ->selectRaw("Sum(If(product_move_type In ('purchasing', 'inventory'), $report_field, -$report_field)) As all_time_totals");
}


function from_our_storages($report_storage_id, $report_field) {
    //dd($report_storage_id);
    $from_our_storages = DB::table('product_moves')
        ->where('product_move_type', '=', 'transfering')
        ->where('new_storage_id', '=', $report_storage_id)
        ->groupBy('product_id')
        ->select('product_id')
        ->selectRaw("Sum($report_field) As all_totals");
        for ($i=1; $i<13; $i++) {$from_our_storages = $from_our_storages->selectRaw(/**@lang SQL*/"
            Ifnull(Sum(If(product_move_type = 'transfering' And month(date) = $i, $report_field, 0)),
                0) As month_{$i}_totals
        ");}

    return $from_our_storages;
}


function select_totals_by_month(&$query, $report_field) {
    for ($i=1; $i<13; $i++) {$query = $query->selectRaw(/**@lang SQL*/"
        Sum(
            If(month(date) = $i or month(date) = Null,
                If(this.product_move_type in ('purchasing', 'inventory'), $report_field, -$report_field),
                0
        )) + from_our_storages.month_{$i}_totals As month_{$i}_totals
    ");}

    return $query;
}


function query_totals_of($request, $report_field_i, $report_storage_id, $year) {
    $report_field = ['quantity', 'quantity*price'][$report_field_i];
    $from_our_storages = from_our_storages($report_storage_id, $report_field);
    $all_time_totals = all_time_totals($report_storage_id, $report_field);

    //dd($from_our_storages->ddRawSql());
    $totals = DB::table('product_moves as this')
        ->leftJoinSub($from_our_storages, 'from_our_storages', on('this.product_id', '=', 'from_our_storages.product_id'))
        ->leftJoinSub($all_time_totals, 'all_time_totals', on('this.product_id', '=', 'all_time_totals.product_id'))
        ->where('this.storage_id', '=', $report_storage_id)
        ->where(DB::raw('year(this.date)'), '=', $year)
        ->groupBy('this.product_id')

        ->selectRaw(/**@lang SQL*/"
            (Select name From products Where id = this.product_id) As product_name,
            all_time_totals,
            Sum(If(this.product_move_type In ('purchasing', 'inventory'), $report_field, -$report_field))
                + from_our_storages.all_totals As year_totals");
            select_totals_by_month($totals, $report_field);

    return paginate($totals,
        per_page: session()->get('per_page') ?? 10,
        current_page: $request->current_page ?? 1,
    );
}

