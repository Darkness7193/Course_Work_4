<?php

namespace App\Http\Controllers\ProductMove;

include_once(app_path().'/functions/queries/query_totals_of.php');
include_once(app_path().'/functions/get_year_of_report.php');
include_once(app_path().'/functions/get_used_years.php');

use App\Models\ProductMove;
use App\Models\Storage;
use Illuminate\Routing\Controller;
use Illuminate\View\View;
use Illuminate\Http\Request;




class QuantitiesReport extends Controller
{
    public function __invoke(Request $request) {
        [$view_fields, $headers] = get_columns([
            ['product_id', 'Товар'],
            ['totals_by_ever', 'Всего',],
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

        $used_years = get_used_years($request->storage_for_report);
        $year_of_report = get_year_of_report($request, $used_years);
        $totals = query_totals_of($request,
            intval($request->field_for_report_i),
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
