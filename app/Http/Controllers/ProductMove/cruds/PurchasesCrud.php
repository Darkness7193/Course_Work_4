<?php

namespace App\Http\Controllers\ProductMove\cruds;

include_once(app_path().'/sql/queries/filter_order_paginate.php');

include_once(app_path().'/helpers/pure_php/get_columns.php');
include_once(app_path().'/helpers/get_filler_rows.php');
include_once(app_path().'/helpers/session_setif.php');
include_once(app_path().'/helpers/clear_session.php');
include_once(app_path().'/helpers/is_the_same_route.php');

use App\Models\Product;
use App\Models\ProductMove;
use App\Models\Storage;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\View\View;




class PurchasesCrud extends Controller
{
    public function __invoke(Request $request): View
    {
        [$view_fields, $headers] = get_columns([
            ['date', 'Поступило'],

            ['product_id', 'Товар'],
            ['quantity', 'Кол-во'],
            ['price', 'Цена'],

            ['storage_id', 'Склад'],
            ['comment', 'Комментарий']
        ]);
        $session_items = session_setif([
            'ordered_orders' => [
                $request->ordered_orders,
                [['created_at', 'asc']]
            ],
            'per_page' => $request->per_page,
            'current_page' => $request->current_page
        ]);

        $purchases = filter_order_paginate(ProductMove::where('product_move_type', 'purchasing'), $view_fields);

        return view('pages/cruds/purchases-crud', [
            'paginator' => $purchases,
            'ProductMove' => ProductMove::class,
            'products' => Product::select('id', 'name')->get(),
            'storages' => Storage::select('id', 'name')->get(),
            'filler_rows' => get_filler_rows($purchases, ProductMove::max('id')),
            'search_targets' => session('search_targets')

        ] + $session_items + compact('view_fields', 'headers'));
    }
}
