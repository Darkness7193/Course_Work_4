<?php

namespace App\Http\Controllers\ProductMove\cruds;

include_once(app_path().'/sql/queries/filter_order_paginate.php');
include_once(app_path().'/helpers/pure_php/EmptyRow.php');
include_once(app_path().'/sql/queries/inner_moves.php');

use App\helpers\pure_php\EmptyRow;
use App\Models\Product;
use App\Models\ProductMove;
use App\Models\Storage;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\View\View;


class InnerMovesCrud extends Controller
{
    public function __invoke(Request $request): View
    {
        if ($request->per_page) { $request->session()->put('per_page', $request->per_page); }
        $inner_moves = inner_moves(ProductMove::query());
        [$view_fields, $headers] = get_columns([
            ['date', 'Дата'],

            ['product_move_type', 'Тип'],
            ['storage_id', 'Склад (изначальный)'],
            ['new_storage_id', 'Склад (конечный)'],

            ['product_id', 'Товар'],
            ['quantity', 'Кол-во'],
            ['price', 'Цена'],

            ['comment', 'Комментарий'],
        ]);

        return view('pages/cruds/inner-moves-crud', [
            'paginator' => filter_order_paginate($inner_moves, $view_fields, $request, ['created_at', 'asc']),
            'ProductMove' => ProductMove::class,
            'products' => Product::select('id', 'name')->get(),
            'storages' => Storage::select('id', 'name')->get(),
            'max_id' => ProductMove::max('id'),
            'emptyRow' => new EmptyRow(),
            'search_targets' => $request->search_targets
        ] + compact('view_fields', 'headers'));
    }
}
