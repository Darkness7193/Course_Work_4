<?php

namespace App\Http\Controllers\ProductMove;

include_once(app_path().'/helpers/filter_order_paginate.php');
include_once(app_path().'/helpers/EmptyRow.php');
include_once(app_path().'/helpers/get_columns.php');

use Illuminate\Routing\Controller;
use Illuminate\View\View;
use Illuminate\Http\Request;

use App\Models\ProductMove;
use App\Models\Product;
use App\Models\Storage;
use App\helpers\EmptyRow;





class PurchasesCrud extends Controller
{
    public function __invoke(Request $request): View
    {
        [$view_fields, $headers] = get_columns([
            ['date', 'ПОСТУПИЛО'],

            ['product_id', 'ТОВАР'],
            ['quantity', 'КОЛ-ВО'],
            ['price', 'ЦЕНА'],

            ['storage_id', 'СКЛАД'],
            ['comment', 'КОММЕНТАРИЙ']
        ]);

        if ($request->per_page) { $request->session()->put('per_page', $request->per_page); }
        $purchases = ProductMove::where('product_move_type', 'purchasing');

        return view('pages/purchases-crud', [
            'purchases' => filter_order_paginate($purchases, $view_fields, $request),
            'view_fields' => $view_fields,
            'headers' => $headers,
            'products' => Product::select('id', 'name')->get(),
            'storages' => Storage::select('id', 'name')->get(),
            'max_id' => ProductMove::max('id'),
            'emptyRow' => new EmptyRow(),
            'search_target' => $request->search_target
        ]);
    }
}
