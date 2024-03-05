<?php

include_once(app_path().'/helpers/eloquent/paginate.php');

use Illuminate\Support\Facades\DB;

//sum(if(product_move_type in ('purchasing', 'inventory'), quantity, -quantity))             as total_quantity,
//sum(if(product_move_type in ('purchasing', 'inventory'), quantity*price, -quantity*price)) as income,

function query_quantity_totals($request, $storage_id, $year) {
    $total_quantities_by_months = "";
    for ($i=1; $i<13; $i++) {
        $total_quantities_by_months .= "sum(if(month(date) = $i, quantity, 0)) as quantity_by_month_$i,\n";
    }

    $totals = DB::select("
        select
            (select name from products where id = product_id) as product_name,
            $total_quantities_by_months
            sum(if(product_move_type in ('purchasing', 'inventory'), quantity, -quantity)) as quantity,
            sum(if(product_move_type in ('purchasing', 'inventory'), quantity*price, -quantity*price)) as cost
        from product_moves
        where year(date) = ?
        group by storage_id, product_id, month(date)
        order by storage_id
    ", [$year]);

    return paginate_array($totals,
        per_page: $request->session()->get('per_page') ?? 10,
        current_page: $request->current_page ?? 1,
    );
}
