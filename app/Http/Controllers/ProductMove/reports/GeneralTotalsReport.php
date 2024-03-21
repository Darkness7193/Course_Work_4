<?php

namespace App\Http\Controllers\ProductMove\reports;

include_once(app_path().'/sql/queries/report_totals/general_totals.php');

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\View\View;


class GeneralTotalsReport extends Controller
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
            'totals' => general_product_totals($request),
            'search_targets' => $request->search_targets,
            'view_fields' => $view_fields,
            'headers' => $headers
        ]);
    }
}
