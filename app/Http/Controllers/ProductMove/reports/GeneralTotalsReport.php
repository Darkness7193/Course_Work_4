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
            ['storage_id', 'Склад'],
            ['product_id', 'Товар'],

            ['purchases_cost', 'Стоимость закупки'],
            ['sales_cost', 'Стоимость продажи'],
            ['cost', 'Доход'],

            ['purchases_quantity', 'Кол-во закупки'],
            ['purchases_quantity', 'Кол-во продажи'],
            ['quantity', 'Кол-во остатка'],
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
            'current_report_type' => [$request->current_report_type, 'quantities'],
            'search_targets' => $request->search_targets,
            'per_page' => $request->per_page,
        ]);

        return view('pages/reports/totals-report', [
            'paginator' => general_product_totals($request),
            'used_years' => get_used_years_of(session()->get('report_storage')->id),
            'Storage' => Storage::class,

        ] + $session_items + compact('view_fields', 'headers'));
    }
}
