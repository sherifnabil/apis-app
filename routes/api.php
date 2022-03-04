<?php

use Illuminate\Support\Facades\Route;

/**
 * Registratring Admin Route
*/
Route::post('register', [App\Http\Controllers\Api\AuthController::class, 'register']);

/**
 * Authentication Route
*/
Route::post('login', [App\Http\Controllers\Api\AuthController::class, 'accessToken']);

/**
 * Token Protected Routes
*/
Route::middleware(['auth:api'])->group(function () {
    /**
     * User Logout Token Revoke
    */
    Route::post('logout', [App\Http\Controllers\Api\AuthController::class, 'logout']);

    Route::middleware(['employee' ])->group(function () {
        /**
         * Categories Routes
        */
        Route::prefix('categories')->group(function () {
            /**
             * Get Categories
            */
            Route::get('/', App\Http\Controllers\Api\Categories\IndexController::class);

            /**
            * Get Category Products
            */
            Route::get('products', App\Http\Controllers\Api\Categories\BasedProductController::class);

            /**
             * Store Category
            */
            Route::post('store', App\Http\Controllers\Api\Categories\StoreController::class);

            /**
             * Show Category
            */
            Route::get('{id}', App\Http\Controllers\Api\Categories\ShowController::class);

            /**
             * Update Category
            */
            Route::put('{id}/update', App\Http\Controllers\Api\Categories\UpdateController::class);

            /**
             * Delete Category
            */
            Route::delete('{id}', App\Http\Controllers\Api\Categories\DeleteController::class);
        });

        /**
         * Products Routes
        */
        Route::prefix('products')->group(function () {
            /**
            * Get Products
            */
            Route::get('/', App\Http\Controllers\Api\Products\IndexController::class);

            /**
             * Store Product
            */
            Route::post('store', App\Http\Controllers\Api\Products\StoreController::class);

            /**
             * Show Product
            */
            Route::get('{id}', App\Http\Controllers\Api\Products\ShowController::class);

            /**
             * Update Product
            */
            Route::put('{id}/update', App\Http\Controllers\Api\Products\UpdateController::class);

            /**
             * Delete Product
            */
            Route::delete('{id}', App\Http\Controllers\Api\Products\DeleteController::class);

            /**
             * Upload Products Excel
            */
            Route::post('products-upload', App\Http\Controllers\Api\Products\ExcelUploadController::class);
        });

        /**
         * Admin Routes
        */
        Route::prefix('admins')->middleware(['admin'])->group(function () {
            /**
             * Store Admin
            */
            Route::post('store', App\Http\Controllers\Api\Admins\StoreController::class);

            /**
             * Show Admin
            */
            Route::get('{id}', App\Http\Controllers\Api\Admins\ShowController::class);

            /**
             * Update Admin
            */
            Route::put('{id}/update', App\Http\Controllers\Api\Admins\UpdateController::class);

            /**
             * Delete Admin
            */
            Route::delete('{id}', App\Http\Controllers\Api\Admins\DeleteController::class);
        });

        /**
         * Employees Routes
        */
        Route::prefix('employees')->middleware(['admin'])->group(function () {
            /**
             * Store Employee
            */
            Route::post('store', App\Http\Controllers\Api\Employees\StoreController::class);

            /**
             * Show Employee
            */
            Route::get('{id}', App\Http\Controllers\Api\Employees\ShowController::class);

            /**
             * Update Employee
            */
            Route::put('{id}/update', App\Http\Controllers\Api\Employees\UpdateController::class);

            /**
             * Delete Employee
            */
            Route::delete('{id}', App\Http\Controllers\Api\Employees\DeleteController::class);
        });

        /**
         * Client Routes
        */
        Route::prefix('clients')->middleware(['admin'])->group(function () {
            /**
             * Store Client
            */
            Route::post('store', App\Http\Controllers\Api\Clients\StoreController::class);

            /**
             * Show Client
            */
            Route::get('{id}', App\Http\Controllers\Api\Clients\ShowController::class);

            /**
             * Update Client
            */
            Route::put('{id}/update', App\Http\Controllers\Api\Clients\UpdateController::class);

            /**
             * Delete Client
            */
            Route::delete('{id}', App\Http\Controllers\Api\Clients\DeleteController::class);
        });

        /**
         * Client Purchases
        */
        Route::prefix('client-products')->middleware(['client'])->group(function () {
            /**
             * Client Purchases
            */
            Route::post('/', App\Http\Controllers\Api\ClientProducts\IndexController::class);

            /**
             * Store Client Purchase
            */
            Route::post('store', App\Http\Controllers\Api\ClientProducts\StoreController::class);

            /**
             * Show Client Purchases
            */
            Route::get('{id}', App\Http\Controllers\Api\ClientProducts\ShowController::class);

            /**
             * Update Client Purchases
            */
            Route::put('{id}/update', App\Http\Controllers\Api\ClientProducts\UpdateController::class);

            /**
             * Delete Client Purchases
            */
            Route::delete('{id}', App\Http\Controllers\Api\ClientProducts\DeleteController::class);
        });
    });
});
