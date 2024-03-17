<?php

namespace App\Http\Controllers\ProductMove\reports;

include_once(app_path().'/sql/queries/filter_order_paginate.php');
include_once(app_path().'/sql/queries/quantity_totals.php');
include_once(app_path().'/helpers/get_used_years_of.php');
include_once(app_path().'/helpers/pure_php/coalesce.php');

use App\Models\Storage;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;


class QuantitiesReport extends Controller
{
    public function __invoke(Request $request) {
        [$view_fields, $headers] = get_columns([
            ['product_name', 'Товар'],
            ['all_time_totals', 'Всего'],
            ['year_totals', 'Год'],

            ['month_1_totals',  'Янв'],
            ['month_2_totals',  'Фев'],
            ['month_3_totals',  'Мар'],
            ['month_4_totals',  'Апр'],
            ['month_5_totals',  'Май'],
            ['month_6_totals',  'Июн'],
            ['month_7_totals',  'Июл'],
            ['month_8_totals',  'Авг'],
            ['month_9_totals',  'Сен'],
            ['month_10_totals', 'Окт'],
            ['month_11_totals', 'Ноя'],
            ['month_12_totals', 'Дек']
        ]);

        $is_cost_report = ($request->is_cost_report ?? 1) ? 0 : 1;
        $is_report_storage_change = $request->report_storage_id !== null;

        session(['report_storage' => coalesce([
            Storage::find($request->report_storage_id),
            session('report_storage'),
            Storage::first(),
            (object)['id'=>null, 'name'=>'Складов нет']
        ]) ]);
        $used_years = get_used_years_of(session()->get('report_storage')->id);
        session(['report_year' => coalesce([
            $request->report_year,
            $is_report_storage_change ? null : session('report_year'),
            max($used_years ?: [null]),
            null
        ]) ]);
        $totals = quantity_totals(session()->get('report_storage')->id, session('report_year'), $is_cost_report);

        return view('pages/reports/quantities-report', [
            'totals' => filter_order_paginate($totals, $view_fields, $request, ['product_name', 'asc']),
            'search_targets' => $request->search_targets,
            'view_fields' => $view_fields,
            'headers' => $headers,
            'Storage' => Storage::class,
            'used_years' => $used_years,
            'report_year' => session('report_year'),
            'report_storage' => session('report_storage'),
            'is_cost_report' => $is_cost_report
        ]);
    }
}
