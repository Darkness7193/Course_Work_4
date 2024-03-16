<?php

include(app_path().'/helpers/post_to_get_route.php');

use App\Http\Controllers\Home;
use Illuminate\Support\Facades\Route;

/**
 * @var string $post_to_get_route
 */


Route::get('', Home::class)->name('home');


Route::group(['namespace' => 'App\Http\Controllers\ProductMove'], function() {
    Route::get('product_moves/purchases_crud', 'PurchasesCrud')->name('product_moves.purchases_crud');
    Route::get('product_moves/sales_crud', 'SalesCrud')->name('product_moves.sales_crud');
    Route::get('product_moves/inner_moves_crud', 'InnerMovesCrud')->name('product_moves.inner_moves_crud');
    Route::get('product_moves/totals_report', 'reports\TotalsReport')->name('product_moves.totals_report');
    Route::get('product_moves/quantities_report', 'reports\QuantitiesReport')->name('product_moves.quantities_report');

    Route::post('product_moves/bulk_update_or_create', 'UpdateOrCreateInBulk')->name('product_moves.bulk_update_or_create');
    Route::post('product_moves/bulk_delete', 'DeleteInBulk')->name('product_moves.bulk_delete');
    Route::post('product_moves/set_filter', 'SetFilter')->name('product_moves.set_filter');
    Route::post('product_moves/set_order', 'SetOrder')->name('product_moves.set_order');
});


Route::post('post_to_get_route', $post_to_get_route)->name('post_to_get_route');
