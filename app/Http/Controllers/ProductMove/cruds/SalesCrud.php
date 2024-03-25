<?php

namespace App\Http\Controllers\ProductMove\cruds;

include_once(app_path().'/sql/queries/filter_order_paginate.php');
include_once(app_path().'/helpers/pure_php/EmptyRow.php');

use App\helpers\pure_php\EmptyRow;
use App\Models\Product;
use App\Models\ProductMove;
use App\Models\Storage;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\View\View;


class SalesCrud extends Controller
{
    public function __invoke(Request $request): View
    {
        if ($request->per_page) { session()->put('per_page', $request->per_page); }
        $sales = ProductMove::where('product_move_type', 'selling');
        [$view_fields, $headers] = get_columns([
            ['date', 'Продано'],

            ['product_id', 'Товар'],
            ['quantity', 'Кол-во'],
            ['price', 'Цена'],

            ['storage_id', 'Склад'],
            ['comment', 'Комментарий']
        ]);

        return view('pages/cruds/sales-crud', [
            'paginator' => filter_order_paginate($sales, $view_fields, $request, ['created_at', 'asc']),
            'ProductMove' => ProductMove::class,
            'products' => Product::select('id', 'name')->get(),
            'storages' => Storage::select('id', 'name')->get(),
            'emptyRow' => new EmptyRow(),
            'search_targets' => $request->search_targets
        ] + compact('view_fields', 'headers'));
    }
}
