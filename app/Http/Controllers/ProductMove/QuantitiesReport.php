<?php

namespace App\Http\Controllers\ProductMove;

include_once(app_path().'/functions/queries/query_quantity_totals.php');

use Illuminate\Routing\Controller;
use Illuminate\View\View;
use Illuminate\Http\Request;




class QuantitiesReport extends Controller
{
    public function __invoke(Request $request): View {
        [$view_fields, $headers] = get_columns([
            ['storage_id', 'Склад'],
            ['product_id', 'Товар'],

            ['cost', 'Стоимость'],
            ['quantity', 'Кол-во'],
            ['quantity_month_1', 'Янв',],
            ['quantity_month_2', 'Фев',],
            ['quantity_month_3', 'Мар',],
            ['quantity_month_4', 'Апр',],
            ['quantity_month_5', 'Май',],
            ['quantity_month_6', 'Июн',],
            ['quantity_month_7', 'Июл',],
            ['quantity_month_8', 'Авг',],
            ['quantity_month_9', 'Сен',],
            ['quantity_month_10', 'Окт',],
            ['quantity_month_11', 'Ноя',],
            ['quantity_month_12', 'Дек',]
        ]);

        $totals = query_quantity_totals($request, 1061, 2024);

        //dd($totals);

        return view('pages/quantities-report', [
            'totals' => $totals,
            'search_targets' => $request->search_targets,
            'view_fields' => $view_fields,
            'headers' => $headers,
        ]);
    }
}
