<?php


use App\Models\ProductMove;
use Illuminate\Support\Facades\DB;


function get_product_totals($request) {
    $totals = ProductMove::
    where('product_move_type', 'purchasing')->
    select(
        'storage_id',
        'product_id',
        DB::raw('sum(quantity) as total_purchase_quantity'),
        DB::raw('sum(price) as total_purchase_price'))->
    groupBy('storage_id', 'product_id');
    paginate($totals,
        per_page: $request->session()->get('per_page') ?? 10,
        current_page: $request->current_page ?? 1,
    );

    return $totals;
}
