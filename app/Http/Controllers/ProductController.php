<?php

namespace App\Http\Controllers;

include_once(app_path().'/sql/queries/filter_order_paginate.php');
include_once(app_path().'/helpers/pure_php/EmptyRow.php');
include_once(app_path().'/helpers/pure_php/get_columns.php');

use App\helpers\pure_php\EmptyRow;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
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
            ['is_to_sale', 'На продажу']
        ]);

        if ($request->per_page) { $request->session()->put('per_page', $request->per_page); }
        $products = Product::query();

        return view('pages/cruds/products-crud', [
            'paginator' => filter_order_paginate($products, $view_fields, $request, ['created_at', 'asc']),
            'Product' => Product::class,
            'max_id' => Product::max('id'),
            'emptyRow' => new EmptyRow(),
            'search_targets' => $request->search_targets
        ] + compact('view_fields', 'headers'));
    }
}
