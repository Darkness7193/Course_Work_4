<?php

namespace App\Http\Controllers;

include(app_path().'/helpers/multi_fields_search.php');
include(app_path().'/helpers/paginate.php');
include(app_path().'/helpers/filter_order_paginate.php');
include(app_path().'/helpers/get_product_totals.php');


use App\Models\Product;
use App\Models\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Models\ProductMove;


class ProductMoveController extends Controller {

    public function purchases_crud(Request $request): View
    {
        if ($request->per_page) {
            $request->session()->put('per_page', $request->per_page);
        }

        return view('pages/purchases-crud', [
            'purchases' => filter_order_paginate(ProductMove::where('product_move_type', 'purchasing'), $request),
            'view_fields' => ProductMove::view_fields(),
            'products' => Product::select('id', 'name')->get(),
            'storages' => Storage::select('id', 'name')->get(),
            'max_id' => ProductMove::max('id'),
        ]);
    }


    public function sales_crud(Request $request): View
    {
        if ($request->per_page) {
            $request->session()->put('per_page', $request->per_page);
        }

        return view('pages/sales-crud', [
            'sales' => filter_order_paginate(ProductMove::where('product_move_type', 'selling'), $request),
            'view_fields' => ProductMove::view_fields(),
            'products' => Product::select('id', 'name')->get(),
            'storages' => Storage::select('id', 'name')->get(),
            'max_id' => ProductMove::max('id'),
        ]);
    }


    public function show_totals_report(Request $request): View {

        return view('pages/totals_report', ['totals' => get_product_totals($request)]);
    }


    public function bulk_update_or_create(Request $request): void
    {
        $view_fields_count = count(ProductMove::view_fields());

        foreach ($request->updated_rows as $row_id => $updated_cells) {
            $purchase = ProductMove::find($row_id);

            if ($purchase === null) {
                if (count($updated_cells) === $view_fields_count) {
                    ProductMove::create(array_merge($updated_cells, ['product_move_type' => $request->product_move_type]));
                }
            } else {
                $purchase->update($updated_cells);
            }
        }
    }


    public function bulk_delete(Request $request): void {
        $ids = $request->all()['deleted_rows'];
        foreach ($ids as $id) {
            ProductMove::find($id)->delete();
        }
    }
}
