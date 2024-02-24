<?php

include(app_path().'/helpers/post_to_get_route.php');

use Illuminate\Support\Facades\Route;

/**
 * @var string $post_to_get_route
 */


Route::group(['namespace' => 'App\Http\Controllers\ProductMove'], function() {
    Route::get('product_moves/purchases_crud', 'PurchasesCrudController')->name('product_moves.purchases_crud');
    Route::get('product_moves/sales_crud', 'SalesCrudController')->name('product_moves.sales_crud');
    Route::get('product_moves/show_totals_report', 'ShowTotalsReportController')->name('product_moves.show_totals_report');

    Route::post('product_moves/bulk_update_or_create', 'BulkUpdateOrCreateController')->name('product_moves.bulk_update_or_create');
    Route::post('product_moves/bulk_delete', 'BulkDeleteController')->name('product_moves.bulk_delete');
});


Route::post('post_to_get_route', $post_to_get_route)->name('post_to_get_route');
