<?php

namespace App\Http\Controllers\ProductMove\cruds;

include_once(app_path().'/sql/queries/filter_order_paginate.php');
include_once(app_path().'/sql/queries/inner_moves.php');

include_once(app_path().'/helpers/get_filler_rows.php');
include_once(app_path().'/helpers/session_setif.php');

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
        $session_items = session_setif([
            'search_targets' => $request->search_targets,
            'ordered_orders' => [
                $request->ordered_orders,
                [['created_at', 'asc']]
            ],
            'per_page' => $request->per_page,
            'current_page' => $request->current_page
        ]);

        $inner_moves = filter_order_paginate(inner_moves(ProductMove::query()), $view_fields);

        return view('pages/cruds/inner-moves-crud', [
            'paginator' => $inner_moves,
            'ProductMove' => ProductMove::class,
            'products' => Product::select('id', 'name')->get(),
            'storages' => Storage::select('id', 'name')->get(),
            'filler_rows' => get_filler_rows($inner_moves, Storage::max('id')),
        ] + $session_items + compact('view_fields', 'headers'));
    }
}
