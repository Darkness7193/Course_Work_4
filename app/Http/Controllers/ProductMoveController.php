<?php

namespace App\Http\Controllers;

include(app_path().'/helpers/multi_fields_search.php');
include(app_path().'/helpers/paginate.php');
include(app_path().'/helpers/search_order_paginate.php');


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

        return view('purchases-crud', [
            'purchases' => search_order_paginate(ProductMove::query(), $request),
            'view_fields' => ProductMove::view_fields(),
            'products' => Product::select('id', 'name')->get(),
            'storages' => Storage::select('id', 'name')->get(),
            'max_id' => ProductMove::max('id'),
        ]);
    }


    public function bulk_update_or_create(Request $request): void
    {
        $view_fields_count = count(ProductMove::view_fields());

        foreach ($request->all() as $row_id => $updated_cells) {
            $purchase = ProductMove::find($row_id);

            if ($purchase === null) {
                if (count($updated_cells) === $view_fields_count) {
                    ProductMove::create(array_merge($updated_cells, ['product_move_type' => 'purchase']));
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


    public function show_totals_report(Request $request): View {
        $totals = ProductMove::
            where('product_move_type', 'purchase')->
            select(
                'storage_id',
                'product_id',
                DB::raw('sum(quantity) as total_purchase_quantity'),
                DB::raw('sum(price) as total_purchase_price'))->
            groupBy('storage_id', 'product_id');
            paginate($totals,
                per_page: $request->session()->get('per_page') ?? 10,
                current_page: $request->current_page ?? 1,
            );

        return view('totals_report', ['totals' => $totals]);
    }
}
