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
            ['quantity_month_1', 'Январь',],
            ['quantity_month_2', 'Февраль',],
            ['quantity_month_3', 'Март',],
            ['quantity_month_4', 'Апрель',],
            ['quantity_month_5', 'Май',],
            ['quantity_month_6', 'Июнь',],
            ['quantity_month_7', 'Июль',],
            ['quantity_month_8', 'Август',],
            ['quantity_month_9', 'Сентябрь',],
            ['quantity_month_10', 'Октябрь',],
            ['quantity_month_11', 'Ноябрь',],
            ['quantity_month_12', 'Декабрь',]
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
