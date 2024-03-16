<?php

use Illuminate\Support\Facades\DB;




function all_time_totals($report_storage_id, $quantity_or_cost) {
    return DB::table('product_moves')
        ->where('storage_id', '=', $report_storage_id)
        ->groupBy('product_id')

        ->select('product_id As product_id')
        ->selectRaw("Sum(If(product_move_type In ('purchasing', 'inventory'), $quantity_or_cost, -$quantity_or_cost)) As all_time_totals");
}
