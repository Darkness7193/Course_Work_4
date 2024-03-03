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
            ['storage_id', 'Склад'],
            ['product_id', 'Товар'],

            ['total_purchases_cost', 'Стоимость закупки'],
            ['total_sales_cost', 'Стоимость продажи'],
            ['income', 'Доход'],

            ['total_purchases_quantity', 'Кол-во закупки'],
            ['total_purchases_quantity', 'Кол-во продажи'],
            ['total_quantity', 'Кол-во остатка'],
        ]);

        return view('pages/totals_report', [
            'totals' => get_product_totals($request),
            'search_targets' => $request->search_targets,
            'view_fields' => $view_fields,
            'headers' => $headers
        ]);
    }
}
