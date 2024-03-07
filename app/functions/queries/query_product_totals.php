<?php

include_once(app_path().'/helpers/eloquent/paginate.php');

use Illuminate\Support\Facades\DB;




function query_product_totals($request) {
    $totals = DB::select("
        SELECT
            (SELECT name FROM storages WHERE id = storage_id) AS storage_name,
            (SELECT name FROM products WHERE id = product_id) AS product_name,
            sum(if(product_move_type IN ('purchasing', 'inventory'), quantity, -quantity)) AS quantity,
            sum(if(product_move_type IN ('purchasing', 'inventory'), quantity*price, -quantity*price)) AS cost,
            sum(if(product_move_type = 'purchasing', quantity, 0))       AS purchases_quantity,
            sum(if(product_move_type = 'purchasing', price*quantity, 0)) AS purchases_cost,
            sum(if(product_move_type = 'selling', quantity, 0))          AS sales_quantity,
            sum(if(product_move_type = 'selling', price*quantity, 0))    AS sales_cost
        FROM product_moves
        GROUP BY storage_id, product_id
    ");


    return paginate_array($totals,
        per_page: $request->session()->get('per_page') ?? 10,
        current_page: $request->current_page ?? 1,
    );
}
