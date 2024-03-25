<?php

namespace App\Http\Controllers;

include_once(app_path().'/sql/queries/filter_order_paginate.php');
include_once(app_path().'/helpers/pure_php/EmptyRow.php');
include_once(app_path().'/helpers/pure_php/get_columns.php');
include_once(app_path().'/helpers/get_filler_rows.php');

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
        ]);
        if ($request->per_page) { $request->session()->put('per_page', $request->per_page); }

        $products = filter_order_paginate(Product::query(), $view_fields, $request, ['created_at', 'asc']);

        return view('pages/cruds/products-crud', [
            'paginator' => $products,
            'Product' => Product::class,
            'filler_rows' => get_filler_rows($products, Product::max('id')),
            'search_targets' => $request->search_targets

        ] + compact('view_fields', 'headers'));
    }
}
