<?php

include_once(app_path().'/helpers/eloquent/paginate.php');

use Illuminate\Support\Facades\DB;




function query_product_totals($request) {
    $totals = DB::select("
        select
            (select name from storages where id = storage_id) as storage_name,
            (select name from products where id = product_id) as product_name,
            sum(if(product_move_type in ('purchasing', 'inventory'), quantity, -quantity)) as quantity,
            sum(if(product_move_type in ('purchasing', 'inventory'), quantity*price, -quantity*price)) as cost,
            sum(if(product_move_type = 'purchasing', quantity, 0))       as purchases_quantity,
            sum(if(product_move_type = 'purchasing', price*quantity, 0)) as purchases_cost,
            sum(if(product_move_type = 'selling', quantity, 0))          as sales_quantity,
            sum(if(product_move_type = 'selling', price*quantity, 0))    as sales_cost
        from product_moves
        group by storage_id, product_id
    ");


    return paginate_array($totals,
        per_page: $request->session()->get('per_page') ?? 10,
        current_page: $request->current_page ?? 1,
    );
}
