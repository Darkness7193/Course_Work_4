<?php

include_once(app_path().'/helpers/eloquent/paginate.php');

use App\Models\Storage;
use Illuminate\Support\Facades\DB;


function get_totals_by_months($calculated_field) {
    $totals_by_months = "";

    for ($i=1; $i<13; $i++) {
        $totals_by_months .= "
            sum(
                if(month(date) = $i,
                    if(product_move_type in ('purchasing', 'inventory'),
                        $calculated_field, -$calculated_field
                    ), 0
            )) as totals_by_month_$i";

        if ($i !== 12) { $totals_by_months .= ",\n"; }
    }

    return $totals_by_months;
}


function query_quantity_or_cost_totals($request, $field_for_report_i, $storage_id, $year) {
    $storage_id = $storage_id ?: Storage::first()->id;
    $calculated_field = ['quantity', 'quantity*price'][$field_for_report_i];
    $total_by_months = get_totals_by_months($calculated_field);

    $totals = DB::select(/**@lang SQL*/"
        WITH transfered AS (
            SELECT
                product_id AS transfered_product_id,
                sum($calculated_field) AS transfered_quantity

            FROM product_moves
            WHERE new_storage_id = ? AND product_move_type = 'transfering'
            GROUP BY product_id
        ),

        ever AS (
            SELECT
                product_id AS ever_product_id,
                sum(IF(product_move_type IN ('purchasing', 'inventory'), $calculated_field, -$calculated_field)) AS ever_quantity

            FROM product_moves
            GROUP BY product_id
        )

        SELECT
            (SELECT name FROM products WHERE id = product_id) AS product_name,
            ever_quantity AS totals_by_ever,
            sum(if(product_move_type IN ('purchasing', 'inventory'), $calculated_field, -$calculated_field))
                - transfered_quantity AS totals_by_year,
            $total_by_months
        FROM product_moves
            LEFT JOIN transfered
            ON product_id = transfered_product_id

            LEFT JOIN ever
            ON product_id = ever_product_id
        WHERE storage_id = ? AND year(date) = ?
        GROUP BY product_id
        ",
        [$storage_id, $storage_id, $year]
    );

    return paginate_array($totals,
        per_page: $request->session()->get('per_page') ?? 10,
        current_page: $request->current_page ?? 1,
    );
}
