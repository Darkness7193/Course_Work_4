<?php

include_once(app_path().'/helpers/eloquent/paginate.php');

use App\Models\Storage;
use Illuminate\Support\Facades\DB;


function get_totals_by_months($calculated_field) {
    $totals_by_months = "";

    for ($i=1; $i<13; $i++) {
        $totals_by_months .= "
            Sum(
                If(month(date) = $i,
                    If(product_move_type In ('purchasing', 'inventory'), $calculated_field, -$calculated_field),
                    0
            )) As totals_by_month_$i";

        if ($i !== 12) { $totals_by_months .= ",\n"; }
    }

    return $totals_by_months;
}


function query_quantity_or_cost_totals($request, $field_for_report_i, $storage_id, $year) {
    $storage_id = $storage_id ?: Storage::first()->id;
    $calculated_field = ['quantity', 'quantity*price'][$field_for_report_i];
    $total_by_months = get_totals_by_months($calculated_field);

    $totals = DB::select(/**@lang SQL*/"
        With transfered As (
            Select product_id As transfered_product_id,
                sum($calculated_field) As transfered_quantity
            From product_moves
            Where storage_id = ? And product_move_type = 'transfering'
            Group By product_id
        ),

        ever As (
            Select product_id As ever_product_id,
                sum(if(product_move_type In ('purchasing', 'inventory'), $calculated_field, -$calculated_field)) As ever_quantity
            From product_moves
            Group By product_id
        )

        Select (Select name From products Where id = product_id) As product_name,
            ever_quantity As totals_by_ever,
            sum(if(product_move_type In ('purchasing', 'inventory'), $calculated_field, -$calculated_field))
                - transfered_quantity As totals_by_year,
            $total_by_months
        From product_moves
            Left Join transfered
            On product_id = transfered_product_id

            Left Join ever
            On product_id = ever_product_id
        Where storage_id = ? And year(date) = ?
        Group By product_id
        ",
        [$storage_id, $storage_id, $year]
    );

    return paginate_array($totals,
        per_page: $request->session()->get('per_page') ?? 10,
        current_page: $request->current_page ?? 1,
    );
}
