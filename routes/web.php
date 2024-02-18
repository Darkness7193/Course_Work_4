<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PurchaseController;
include(app_path().'/helpers/post_to_get_route.php');

/**
 * @var string $post_to_get_route
 */


Route::get('purchases/show_crud', [PurchaseController::class, 'show_crud'])
    ->name('purchases.show_crud');

Route::get('purchases/show_totals_report', [PurchaseController::class, 'show_totals_report'])
    ->name('purchases.show_totals_report');

Route::post('purchases/bulk_update_or_create', [PurchaseController::class, 'bulk_update_or_create'])
    ->name('purchases.bulk_update_or_create');

Route::post('purchases/create', [PurchaseController::class, 'create'])
    ->name('purchases.create');

Route::post('purchases/bulk_delete', [PurchaseController::class, 'bulk_delete'])
    ->name('purchases.bulk_delete');


Route::post('post_to_get_route', $post_to_get_route)
    ->name('post_to_get_route');
