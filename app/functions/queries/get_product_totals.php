<?php

include_once(app_path().'/helpers/eloquent/paginate.php');

use Illuminate\Support\Facades\DB;



function test_query() {
    $totals = "
    select
        storage_id,
        product_id,
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
        sum(if(product_move_type = 'purchasing', quantity, 0))          as total_purchases_quantity,
        sum(if(product_move_type = 'purchasing', price*quantity, 0))    as total_purchases_cost,
        sum(if(product_move_type = 'selling', quantity, 0))             as total_sales_quantity,
        sum(if(product_move_type = 'selling', price*quantity, 0))       as total_sales_cost
    from product_moves
    group by storage_id, product_id
    ";

    $moved_products = "
    select new_storage_id, product_id, sum(quantity) as total_quantity, sum(price*quantity) as total_cost
    from product_moves
    where product_move_type = 'transfering'
    group by new_storage_id, product_id
    ";

    return "
    select
        (select name from storages where id = totals.storage_id) as storage_name,
        (select name from products where id = totals.product_id) as product_name,
        totals.total_quantity + moved_products.total_quantity as total_quantity,
        totals.income + moved_products.total_cost as income,
        totals.total_purchases_quantity,
        totals.total_purchases_cost,
        totals.total_sales_quantity,
        totals.total_sales_cost
    from ($totals) as totals
        inner join ($moved_products) as moved_products
            on totals.storage_id = moved_products.new_storage_id
            or totals.product_id = moved_products.product_id
    ";
}


function get_product_totals($request) {
    $totals = "
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
        sum(if(product_move_type = 'purchasing', quantity, 0))       as total_purchases_quantity,
        sum(if(product_move_type = 'purchasing', price*quantity, 0)) as total_purchases_cost,
        sum(if(product_move_type = 'selling', quantity, 0))          as total_sales_quantity,
        sum(if(product_move_type = 'selling', price*quantity, 0))    as total_sales_cost
    from product_moves
    group by storage_id, product_id
    ";

    $items_1 = DB::select($totals);
    $items_2 = DB::select(test_query());

    return paginate_array($items_1,
        per_page: $request->session()->get('per_page') ?? 10,
        current_page: $request->current_page ?? 1,
    );
}
