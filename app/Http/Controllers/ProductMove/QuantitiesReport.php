<?php

namespace App\Http\Controllers\ProductMove;

include_once(app_path().'/functions/queries/query_totals_of.php');

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

            ['totals_by_year', 'Год',],
            ['totals_by_month_1', 'Янв',],
            ['totals_by_month_2', 'Фев',],
            ['totals_by_month_3', 'Мар',],
            ['totals_by_month_4', 'Апр',],
            ['totals_by_month_5', 'Май',],
            ['totals_by_month_6', 'Июн',],
            ['totals_by_month_7', 'Июл',],
            ['totals_by_month_8', 'Авг',],
            ['totals_by_month_9', 'Сен',],
            ['totals_by_month_10', 'Окт',],
            ['totals_by_month_11', 'Ноя',],
            ['totals_by_month_12', 'Дек',]
        ]);

        $used_years = get_used_years();
        $year_of_report = get_year_of_report($request, $used_years);
        $totals = query_totals_of($request,
            ['quantity', 'quantity*price'][intval($request->field_for_report_i)],
            $request->storage_id_of_report,
            $year_of_report
        );

        return view('pages/quantities-report', [
            'totals' => $totals,
            'search_targets' => $request->search_targets,
            'view_fields' => $view_fields,
            'headers' => $headers,
            'Storage' => Storage::class,
            'storage_id_of_report' => $request->storage_id_of_report,
            'used_years' => $used_years,
            'year_of_report' => $year_of_report,
            'field_for_report_i' => (intval($request->field_for_report_i) + 1) % 2
        ]);
    }
}
