<?php

include_once(app_path().'/sql/helpers/paginate.php');

use Illuminate\Support\Facades\DB;




function general_product_totals($request, $report_options) {
    [$report_storage, $report_year, $is_cost_report] = array_values($report_options);
    $quantity_or_cost = $is_cost_report ? 'quantity*price' : 'quantity';

    $totals = DB::select("
        Select
            (Select name From storages Where id = storage_id) As storage_name,
            (Select name From products Where id = product_id) As product_name,
            sum(if(product_move_type In ('purchasing', 'inventory'), $quantity_or_cost, -$quantity_or_cost)) As quantity_totals,
            sum(if(product_move_type = 'purchasing', $quantity_or_cost, 0)) As purchases_totals,
            sum(if(product_move_type = 'selling', $quantity_or_cost, 0)) As sales_totals

        From product_moves
        Where storage_id = $report_storage->id
        Group By storage_id, product_id
    ");


    return paginate_array($totals,
        per_page: session()->get('per_page') ?? 10,
        current_page: $request->current_page ?? 1,
    );
}
