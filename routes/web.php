<?php

include(app_path().'/helpers/post_to_get_route.php');

use App\Http\Controllers\Home;
use Illuminate\Support\Facades\Route;

/**
 * @var string $post_to_get_route
 */


Route::get('', Home::class)->name('home');


Route::group(['namespace' => 'App\Http\Controllers\ProductMove'], function() {
    Route::get('product_moves/purchases_crud', 'cruds\PurchasesCrud')->name('product_moves.purchases_crud');
    Route::get('product_moves/sales_crud', 'cruds\SalesCrud')->name('product_moves.sales_crud');
    Route::get('product_moves/inner_moves_crud', 'cruds\InnerMovesCrud')->name('product_moves.inner_moves_crud');
    Route::get('product_moves/general_totals_report', 'reports\GeneralTotalsReport')->name('product_moves.general_totals_report');
    Route::get('product_moves/quantities_report', 'reports\QuantitiesReport')->name('product_moves.quantities_report');

    Route::post('product_moves/bulk_update_or_create', 'UpdateOrCreateInBulk')->name('product_moves.bulk_update_or_create');
    Route::post('product_moves/bulk_delete', 'DeleteInBulk')->name('product_moves.bulk_delete');
    Route::post('product_moves/set_filter', 'SetFilter')->name('product_moves.set_filter');
    Route::post('product_moves/set_order', 'SetOrder')->name('product_moves.set_order');
});


Route::group(['namespace' => 'App\Http\Controllers\Product'], function() {
    Route::get('products/crud', 'Crud')->name('products.crud');
});


Route::post('post_to_get_route', $post_to_get_route)->name('post_to_get_route');
