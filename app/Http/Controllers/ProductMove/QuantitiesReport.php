<?php

namespace App\Http\Controllers\ProductMove;

include_once(app_path().'/functions/queries/query_quantity_totals.php');

use App\Models\ProductMove;
use App\Models\Storage;
use Illuminate\Routing\Controller;
use Illuminate\View\View;
use Illuminate\Http\Request;


function get_used_years() {
    $years = [];
    foreach (ProductMove::all() as $product_move) {
        $years[] = $product_move->date->year;
    }
    $years = array_values(array_unique($years));
    rsort($years);

    return $years;
}


function get_year_of_report($request, $used_years) {
    if ($request->year_of_report) {
        return $request->year_of_report;
    } else if (in_array(now()->year, $used_years)) {
        return now()->year;

    } else if (!empty($used_years)) {
        return $used_years[0];
    } else {
        return 'Материалов нет';
    }
}


class QuantitiesReport extends Controller
{
    public function __invoke(Request $request): View {
        [$view_fields, $headers] = get_columns([
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

        $used_years = get_used_years();
        $year_of_report = get_year_of_report($request, $used_years);
        $totals = query_quantity_totals($request, $request->storage_id_of_report, $year_of_report);

        return view('pages/quantities-report', [
            'totals' => $totals,
            'search_targets' => $request->search_targets,
            'view_fields' => $view_fields,
            'headers' => $headers,
            'Storage' => Storage::class,
            'storage_id_of_report' => $request->storage_id_of_report,
            'used_years' => $used_years,
            'year_of_report' => $year_of_report
        ]);
    }
}
