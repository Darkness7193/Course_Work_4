<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductMoveController;
include(app_path().'/helpers/post_to_get_route.php');

/**
 * @var string $post_to_get_route
 */


Route::get('product_moves/purchases_crud', [ProductMoveController::class, 'purchases_crud'])
    ->name('product_moves.purchases_crud');

Route::get('product_moves/sales_crud', [ProductMoveController::class, 'sales_crud'])
    ->name('product_moves.sales_crud');

Route::get('product_moves/show_totals_report', [ProductMoveController::class, 'show_totals_report'])
    ->name('product_moves.show_totals_report');


Route::post('product_moves/bulk_update_or_create', [ProductMoveController::class, 'bulk_update_or_create'])
    ->name('product_moves.bulk_update_or_create');

Route::post('product_moves/create', [ProductMoveController::class, 'create'])
    ->name('product_moves.create');

Route::post('product_moves/bulk_delete', [ProductMoveController::class, 'bulk_delete'])
    ->name('product_moves.bulk_delete');


Route::post('post_to_get_route', $post_to_get_route)
    ->name('post_to_get_route');
