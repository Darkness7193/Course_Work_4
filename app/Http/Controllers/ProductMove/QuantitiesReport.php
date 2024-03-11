<?php

namespace App\Http\Controllers\ProductMove;

include_once(app_path().'/functions/queries/query_totals_of.php');
include_once(app_path().'/functions/get_used_years_of.php');
include_once(app_path().'/functions/get_report_year.php');
include_once(app_path().'/helpers/pure_php/coalesce.php');

use App\helpers\pure_php\CoalesceNull;
use App\Models\Storage;
use Illuminate\Routing\Controller;
use Illuminate\Http\Request;


function get_report_storage($report_storage_id) {
    return Storage::find(session()->get('report_storage_id'))
        ?? Storage::first()
        ?? (object)['id'=>null, 'name'=>'Складов нет'];
}


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

        $report_field_i = (intval($request->report_field_i ?? -1) + 1) % 2;


        session(['report_storage' => $report_storage=coalesce([
            Storage::find($request->report_storage_id),
            Storage::first(),
            (object)['id'=>null, 'name'=>'Складов нет']
        ]) ]);
        $used_years = get_used_years_of($report_storage->id);
        session(['report_year' => coalesce([
            $request->report_year,
            max($used_years ?: [null]),
            null
        ]) ]);
        $totals = query_totals_of($request, $report_field_i, $report_storage->id, session('report_year'));

        return view('pages/quantities-report', [
            'totals' => $totals,
            'search_targets' => $request->search_targets,
            'view_fields' => $view_fields,
            'headers' => $headers,
            'Storage' => Storage::class,
            'used_years' => $used_years,
            'report_year' => session('report_year'),
            'report_storage' => session('report_storage'),
            'report_field_i' => $report_field_i
        ]);
    }
}
