<?php

include_once(app_path().'/helpers/eloquent/paginate.php');

use Illuminate\Support\Facades\DB;

//sum(if(product_move_type in ('purchasing', 'inventory'), quantity, -quantity))             as total_quantity,
//sum(if(product_move_type in ('purchasing', 'inventory'), quantity*price, -quantity*price)) as income,

function query_quantity_totals($request, $storage_id, $year) {
    $items = DB::select("
    select
        (select name from storages where id = storage_id) as storage_name,
        (select name from products where id = product_id) as product_name,
        sum(case product_move_type
            when 'purchasing'  then  quantity
            when 'selling'     then -quantity
            when 'liquidating' then -quantity
            when 'inventory'   then  quantity
            when 'transfering' then -quantity
            end) as quantity,
        sum(case product_move_type
            when 'purchasing'  then  quantity*price
            when 'selling'     then -quantity*price
            when 'liquidating' then -quantity*price
            when 'inventory'   then  quantity*price
            when 'transfering' then -quantity*price
            end) as cost
    from product_moves
    where storage_id = ?
        and year(date) = ?
    group by storage_id, product_id
    ", [$storage_id, $year]);


    return paginate_array($items,
        per_page: $request->session()->get('per_page') ?? 10,
        current_page: $request->current_page ?? 1,
    );
}
