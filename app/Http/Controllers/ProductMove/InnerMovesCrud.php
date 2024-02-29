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
        [$view_fields, $headers] = get_columns([
            ['date', 'ДАТА'],

            ['product_move_type', 'ТИП'],
            ['storage_id', 'СКЛАД'],
            ['new_storage_id', 'СКЛАД'],

            ['product_id', 'ТОВАР'],
            ['quantity', 'КОЛ-ВО'],
            ['price', 'ЦЕНА'],

            ['comment', 'КОММЕНТАРИЙ'],
        ]);

        if ($request->per_page) { $request->session()->put('per_page', $request->per_page); }
        $inner_moves = get_inner_moves(ProductMove::query());

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
