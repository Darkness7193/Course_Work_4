<?php

namespace App\Http\Controllers\ProductMove\reports;

include_once(app_path().'/sql/queries/filter_order_paginate.php');
include_once(app_path().'/sql/queries/quantity_totals.php');
include_once(app_path().'/sql/queries/move_type_totals.php');
include_once(app_path().'/helpers/get_used_years_of.php');

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Models\Storage;
use App\Models\ProductMove;



function set_request_defaults(&$request)
{
    $request->report_storage =
        $request->report_storage_id ? Storage::find($request->report_storage_id) : null
        ?? Storage::first()
        ?? (object)['id'=>null, 'name'=>'Складов нет'];

    $request->report_year = $request->report_storage_id === $request->old('report_storage_id')
        ? $request->report_year
        : null;
    $request->flashOnly('report_storage_id');

    $request->current_report_type = $request->current_report_type ?? 'quantities';
}


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
        set_request_defaults($request);

        if (in_array($request->current_report_type, ProductMove::product_move_types())) {
            $totals = move_type_totals($request->current_report_type, $request->report_storage->id, $request->report_year, (bool)$request->is_cost_report);
        } else if ($request->current_report_type === 'quantities') {
            $totals = quantity_totals($request->report_storage->id, $request->report_year, (bool)$request->is_cost_report);
        }

        return view('pages/reports/quantities-report', [
            'totals' => filter_order_paginate($totals, $view_fields, $request, ['product_name', 'asc']),
            'search_targets' => $request->search_targets,
            'view_fields' => $view_fields,
            'headers' => $headers,
            'Storage' => Storage::class,
            'used_years' => get_used_years_of($request->report_storage->id),
            'report_year' => $request->report_year,
            'report_storage' => $request->report_storage,
            'is_cost_report' => $request->is_cost_report,
            'current_report_type' => $request->current_report_type
        ]);
    }
}
