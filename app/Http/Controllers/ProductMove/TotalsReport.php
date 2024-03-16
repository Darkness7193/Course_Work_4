<?php

namespace App\Http\Controllers\ProductMove;

include_once(app_path().'/sql/queries/product_totals.php');

use Illuminate\Routing\Controller;
use Illuminate\View\View;
use Illuminate\Http\Request;




class TotalsReport extends Controller
{
    public function __invoke(Request $request): View {
        [$view_fields, $headers] = get_columns([
            ['storage_id', 'Склад'],
            ['product_id', 'Товар'],

            ['purchases_cost', 'Стоимость закупки'],
            ['sales_cost', 'Стоимость продажи'],
            ['cost', 'Доход'],

            ['purchases_quantity', 'Кол-во закупки'],
            ['purchases_quantity', 'Кол-во продажи'],
            ['quantity', 'Кол-во остатка'],
        ]);

        return view('pages/reports/totals-report', [
            'totals' => product_totals($request),
            'search_targets' => $request->search_targets,
            'view_fields' => $view_fields,
            'headers' => $headers
        ]);
    }
}
