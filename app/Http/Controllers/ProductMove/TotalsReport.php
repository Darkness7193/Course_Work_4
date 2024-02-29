<?php

namespace App\Http\Controllers\ProductMove;

include_once(app_path().'/helpers/get_product_totals.php');

use Illuminate\Routing\Controller;
use Illuminate\View\View;
use Illuminate\Http\Request;




class TotalsReport extends Controller
{
    public function __invoke(Request $request): View {
        [$view_fields, $headers] = get_columns([
            ['storage_id', 'СКЛАД'],
            ['product_id', 'ТОВАР'],

            ['total_purchases_cost', 'СТОИМОСТЬ ЗАКУПКИ'],
            ['total_sales_cost', 'СТОИМОСТЬ ПРОДАЖИ'],
            ['income', 'ДОХОД'],

            ['total_purchases_quantity', 'КОЛ-ВО ЗАКУПКИ'],
            ['total_purchases_quantity', 'КОЛ-ВО ПРОДАЖИ'],
            ['total_quantity', 'КОЛ-ВО ОСТАТКА'],
        ]);

        return view('pages/totals_report', [
            'totals' => get_product_totals($request),
            'search_target' => $request->search_target,
            'view_fields' => $view_fields,
            'headers' => $headers
        ]);
    }
}
