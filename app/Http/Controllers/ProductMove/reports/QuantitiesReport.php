<?php

namespace App\Http\Controllers\ProductMove\reports;

include_once(app_path().'/helpers/get_used_years_of.php');
include_once(app_path().'/helpers/session_setif.php');
include_once(app_path().'/helpers/session_get.php');

include_once(app_path().'/sql/queries/filter_order_paginate.php');
include_once(app_path().'/sql/queries/report_totals/product_totals.php');

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Models\Storage;




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
        $session_items = session_setif([
            'report_storage' => [
                $request->report_storage_id ? Storage::find($request->report_storage_id) : null,
                Storage::first() ?? (object)['id'=>null, 'name'=>'Складов нет']
            ],
            'report_year' => [
                $request->report_storage_id !== session('report_storage_id') ? $request->report_year : null,
            ],
            'is_cost_report' => [(bool)$request->is_cost_report, false],
            'search_targets' => $request->search_targets,
            'current_report_type' => [$request->current_report_type, 'quantities'],
        ]);

        $totals = product_totals(session_get(['current_report_type', 'report_storage', 'report_year', 'is_cost_report']));

        return view('pages/reports/quantities-report', [
            'paginator' => filter_order_paginate($totals, $view_fields, $request, ['product_name', 'asc']),
            'used_years' => get_used_years_of(session()->get('report_storage')->id),
            'Storage' => Storage::class,

        ] + $session_items + compact('view_fields', 'headers')
        );
    }
}

