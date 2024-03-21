<?php

include_once(app_path().'/sql/helpers/paginate.php');

use Illuminate\Support\Facades\DB;




function general_product_totals($request) {
    $totals = DB::select("
        Select
            (Select name From storages Where id = storage_id) As storage_name,
            (Select name From products Where id = product_id) As product_name,
            sum(if(product_move_type In ('purchasing', 'inventory'), quantity, -quantity)) As quantity,
            sum(if(product_move_type In ('purchasing', 'inventory'), quantity*price, -quantity*price)) As cost,
            sum(if(product_move_type = 'purchasing', quantity, 0))       As purchases_quantity,
            sum(if(product_move_type = 'purchasing', price*quantity, 0)) As purchases_cost,
            sum(if(product_move_type = 'selling', quantity, 0))          As sales_quantity,
            sum(if(product_move_type = 'selling', price*quantity, 0))    As sales_cost
        From product_moves
        Group By storage_id, product_id
    ");


    return paginate_array($totals,
        per_page: session()->get('per_page') ?? 10,
        current_page: $request->current_page ?? 1,
    );
}
