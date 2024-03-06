<?php

include_once(app_path().'/helpers/eloquent/paginate.php');

use App\Models\Storage;
use Illuminate\Support\Facades\DB;




function query_totals_of($request, $calculated_field, $storage_id, $year) {
    $total_quantities_by_months = "";
    for ($i=1; $i<13; $i++) {
        $total_quantities_by_months .= "sum(if(month(date) = $i, $calculated_field, 0)) as totals_by_month_$i,\n";
    }

    $totals = DB::select("
        select
            (select name from products where id = product_id) as product_name,
            sum(if(year(date) = $year, $calculated_field, 0)) as totals_by_year,
            $total_quantities_by_months
        from product_moves
        where storage_id = ?
            and year(date) = ?
        group by storage_id, product_id, month(date)
        order by storage_id
        ",
        [$storage_id ?? Storage::first()->id, $year]
    );

    return paginate_array($totals,
        per_page: $request->session()->get('per_page') ?? 10,
        current_page: $request->current_page ?? 1,
    );
}
