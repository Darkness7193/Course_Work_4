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


function query_totals_of($request, $calculated_field, $storage_id, $year) {
    $storage_id = $storage_id ?: Storage::first()->id;
    $total_quantities_by_months = get_totals_by_months($calculated_field);

    $totals = DB::select("
        with transfered as (
            select
                product_id as transfered_product_id,
                sum($calculated_field) as transfered_quantity

            from product_moves
            where new_storage_id = ? and product_move_type = 'transfering'
            group by product_id
        )

        select
            (select name from products where id = product_id) as product_name,
            sum(
                if(year(date) = ?,
                    if(product_move_type in ('purchasing', 'inventory'),
                        $calculated_field, -$calculated_field
                    ), 0
            )) - transfered_quantity as totals_by_year,
            $total_quantities_by_months

        from product_moves left join transfered
            on product_id = transfered_product_id
        where storage_id = ?
            and year(date) = ?
        group by product_id
        ",
        [$storage_id, $year, $storage_id, $year]
    );

    return paginate_array($totals,
        per_page: $request->session()->get('per_page') ?? 10,
        current_page: $request->current_page ?? 1,
    );
}
