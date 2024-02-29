<?php

namespace App\Http\Controllers\ProductMove;

include_once(app_path().'/helpers/filter_order_paginate.php');
include_once(app_path().'/helpers/EmptyRow.php');
include_once(app_path().'/helpers/get_inner_moves.php');

use Illuminate\Routing\Controller;
use Illuminate\View\View;
use Illuminate\Http\Request;

use App\Models\ProductMove;
use App\Models\Product;
use App\Models\Storage;
use App\helpers\EmptyRow;




class InnerMovesCrud extends Controller
{
    public function __invoke(Request $request): View
    {
        if ($request->per_page) { $request->session()->put('per_page', $request->per_page); }
        $inner_moves = get_inner_moves(ProductMove::query());
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

        return view('pages/inner-moves-crud', [
            'inner_moves' => filter_order_paginate($inner_moves, $view_fields, $request),
            'view_fields' => $view_fields,
            'headers' => $headers,
            'ProductMove' => ProductMove::class,
            'products' => Product::select('id', 'name')->get(),
            'storages' => Storage::select('id', 'name')->get(),
            'max_id' => ProductMove::max('id'),
            'emptyRow' => new EmptyRow(),
            'search_target' => $request->search_target
        ]);
    }
}
