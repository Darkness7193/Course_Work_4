<?php

namespace App\Http\Controllers\ProductMove\reports;

include_once(app_path().'/sql/queries/report_totals/general_totals.php');
include_once(app_path().'/helpers/session_setif.php');

use App\Models\Storage;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\View\View;


class GeneralTotalsReport extends Controller
{
    public function __invoke(Request $request): View {
        [$view_fields, $headers] = get_columns([
            ['product_id', 'Товар'],

            ['purchases_totals', 'Закупка'],
            ['sales_totals', 'Продажа'],
            ['quantity_totals', 'Остаток'],
            ['liquidating_totals', 'Утилизация'],
            ['inventory_totals', 'Инвентаризация'],
            ['import_totals', 'Импорт'],
        ]);

        $session_items = session_setif([
            'report_storage' => [
                $request->report_storage_id ? Storage::find($request->report_storage_id) : null,
                Storage::first() ?? (object)['id'=>null, 'name'=>'Складов нет']
            ],
            'report_year' => [
                $request->report_storage_id !== session('report_storage_id') ? $request->report_year : null,
            ],
            'is_cost_report' => [
                (bool)$request->is_cost_report,
                false
            ],
            'per_page' => $request->per_page,
            'current_page' => $request->current_page,
            'ordered_orders' => [
                session('ordered_orders'),
                [['product_name', 'asc']]
            ]
        ]);

        $totals = general_totals(session()->get('report_storage')->id, session('report_year'), session('is_cost_report'));

        return view('pages/reports/totals-report', [
            'paginator' => filter_order_paginate($totals, $view_fields),
            'used_years' => get_used_years_of(session()->get('report_storage')->id),
            'Storage' => Storage::class,
            'search_targets' => session('search_targets')

        ] + $session_items + compact('view_fields', 'headers'));
    }
}
