<?php

include_once(app_path().'/helpers/paginate.php');

use Illuminate\Support\Facades\DB;


function query_totals_2() {
    $purchases = "
    select *
    from product_moves
    where product_move_type = 'purchasing' ";

    $sales = "
    select *
    from product_moves
    where product_move_type = 'selling' ";


    $totals = "
    select
        (select name from storages where id = p.storage_id) as storage_name,
        (select name from products where id = p.product_id) as product_name,

        sum(p.quantity)                                     as total_purchases_quantity,
        sum(s.quantity)                                     as total_sales_quantity,
        sum(p.quantity) - sum(s.quantity)                   as total_quantity,

        sum(p.quantity*p.price)                             as total_purchases_price,
        sum(s.quantity*s.price)                             as total_sales_price,
        sum(p.quantity*p.price) - sum(s.quantity*s.price)   as income

    from ($purchases) as p
        inner join ($sales) as s
            on p.storage_id = s.storage_id
            or p.product_id = s.product_id

    group by
        p.storage_id, p.product_id
    order by
        p.storage_id
    ";

    return $totals;
}


function get_product_totals($request) {
    $totals = DB::select("
    select
        (select name from storages where id = storage_id) as storage_name,
        (select name from products where id = product_id) as product_name,
        sum(case product_move_type
            when 'purchasing'  then  quantity
            when 'selling'     then -quantity
            when 'liquidating' then -quantity
            when 'inventory'   then  quantity
            when 'transfering' then -quantity
            end) as total_quantity,
        sum(case product_move_type
            when 'purchasing'  then  quantity*price
            when 'selling'     then -quantity*price
            when 'liquidating' then -quantity*price
            when 'inventory'   then  quantity*price
            when 'transfering' then -quantity*price
            end) as income,
        sum(if(product_move_type = 'purchasing', price, 0))          as total_purchases_price,
        sum(if(product_move_type = 'purchasing', price*quantity, 0)) as total_purchases_quantity,
        sum(if(product_move_type = 'selling', price, 0))             as total_sales_price,
        sum(if(product_move_type = 'selling', price*quantity, 0))    as total_sales_quantity
    from product_moves
    group by storage_id, product_id
    ");

    return paginate_array($totals,
        per_page: $request->session()->get('per_page') ?? 10,
        current_page: $request->current_page ?? 1,
    );
}
