<?php

include(app_path().'/helpers/post_to_get_route.php');

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\StorageController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;

/**
 * @var string $post_to_get_route
 */


Route::middleware('auth')->group(function () use($post_to_get_route) {
    /*Home*/
    Route::get('', [HomeController::class, 'index'])->name('home');

    /*Cruds & Reports*/
    Route::group(['namespace' => 'App\Http\Controllers\ProductMove'], function() {
        Route::get('product_moves/purchases_crud', 'cruds\PurchasesCrud')->name('product_moves.purchases_crud');
        Route::get('product_moves/sales_crud', 'cruds\SalesCrud')->name('product_moves.sales_crud');
        Route::get('product_moves/inner_moves_crud', 'cruds\InnerMovesCrud')->name('product_moves.inner_moves_crud');
        Route::get('product_moves/general_totals_report', 'reports\GeneralTotalsReport')->name('product_moves.general_totals_report');
        Route::get('product_moves/quantities_report', 'reports\QuantitiesReport')->name('product_moves.quantities_report');
    });

    /*Catalogs*/
    Route::get('products/crud', [ProductController::class, 'index'])->name('products.crud');
    Route::get('storages/crud', [StorageController::class, 'index'])->name('storages.crud');

    /*Commands*/
    Route::post('post_to_get_route', $post_to_get_route)->name('post_to_get_route');
    Route::group(['namespace' => 'App\Http\Controllers\TableViewCommands'], function() {
        Route::post('bulk_update_or_create', 'UpdateOrCreateInBulk')->name('bulk_update_or_create');
        Route::post('bulk_delete', 'DeleteInBulk')->name('bulk_delete');
        Route::post('set_filter', 'SetFilter')->name('set_filter');
        Route::post('set_order', 'SetOrder')->name('set_order');
    });

    /*Profiles*/
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});




require __DIR__.'/auth.php';
