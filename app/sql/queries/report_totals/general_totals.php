<?php

include_once(app_path().'/sql/helpers/paginate.php');

use Illuminate\Support\Facades\DB;




function general_totals($report_storage, $report_year, $is_cost_report) {
    $quantity_or_cost = $is_cost_report ? 'quantity*price' : 'quantity';

    return DB::select("
        Select (Select name From products Where id = product_id) As product_name,
            sum(if(product_move_type In ('purchasing', 'inventory'), $quantity_or_cost, -$quantity_or_cost)) As quantity_totals,
            sum(if(product_move_type = 'purchasing', $quantity_or_cost, 0)) As purchases_totals,
            sum(if(product_move_type = 'selling', $quantity_or_cost, 0)) As sales_totals,
            sum(if(product_move_type = 'liquidating', $quantity_or_cost, 0)) As liquidating_totals,
            sum(if(product_move_type = 'inventory', $quantity_or_cost, 0)) As inventory_totals,
            sum(if(product_move_type = 'transfering', $quantity_or_cost, 0)) As import_totals

        From product_moves
        Where storage_id = $report_storage->id And year(date) = $report_year
        Group By storage_id, product_id
    ");
}
