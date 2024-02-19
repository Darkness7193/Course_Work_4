<?php


use App\Models\ProductMove;
use Illuminate\Support\Facades\DB;


function query_totals() {
    $purchase_totals = "
    select
        storage_id,
        product_id,
        sum(quantity) as total_purchases_quantity,
        sum(price) as total_purchases_price
    from
        product_moves
    where
        product_move_type = 'purchasing'
    group by storage_id, product_id
";


    $selling_totals = "
    select
        storage_id,
        product_id,
        sum(quantity) as total_sales_quantity,
        sum(price) as total_sales_price
    from
        product_moves
    where
        product_move_type = 'selling'
    group by storage_id, product_id
";


    $totals = "
    select *
    from ($purchase_totals) as p
    inner join ($selling_totals) as s
    on
        p.storage_id = s.storage_id and
        p.product_id = s.product_id
";

    return $totals;
}


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
