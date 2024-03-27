<?php

namespace App\Http\Controllers;

include_once(app_path().'/sql/queries/filter_order_paginate.php');

include_once(app_path().'/helpers/pure_php/get_columns.php');
include_once(app_path().'/helpers/get_filler_rows.php');
include_once(app_path().'/helpers/session_setif.php');

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\View\View;




class ProductController extends Controller
{
    public function index(Request $request): View
    {
        [$view_fields, $headers] = get_columns([
            ['name', 'Наименование'],

            ['manufactor', 'Производитель'],
            ['purchase_price', 'Цена закупки'],
            ['selling_price', 'Цена продажи'],

            ['comment', 'Комментарий'],
        ]);
        if (!is_the_same_route()) { Session::forget(['ordered_orders', 'per_page', 'current_page', 'search_targets']); }
        $session_items = session_setif([
            'ordered_orders' => [
                session('ordered_orders'),
                [['created_at', 'asc']]
            ],
            'per_page' => $request->per_page,
            'current_page' => $request->current_page
        ]);

        $products = filter_order_paginate(Product::query(), $view_fields);

        return view('pages/cruds/products-crud', [
            'paginator' => $products,
            'Product' => Product::class,
            'filler_rows' => get_filler_rows($products, Product::max('id')),
            'search_targets' => session('search_targets')

        ] + $session_items + compact('view_fields', 'headers'));
    }
}
