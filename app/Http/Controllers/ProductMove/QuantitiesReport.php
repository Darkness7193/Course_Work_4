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
            ['product_id', 'Товар'],

            ['cost', 'Стоимость'],
            ['quantity', 'Кол-во'],
        ]);

        return view('pages/quantities-report', [
            'totals' => query_quantity_totals($request, 841, 2024),
            'search_targets' => $request->search_targets,
            'view_fields' => $view_fields,
            'headers' => $headers
        ]);
    }
}
