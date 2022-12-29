<?php


use Illuminate\Support\Facades\Route;
use Blog\Http\Controllers\Api\V1\CategoryController;
use Blog\Http\Controllers\Api\V1\PostController;

Route::prefix('v1')
    ->middleware('auth:sanctum')
    ->group(function () {
        Route::apiResource('categories', CategoryController::class);
        Route::apiResource('posts', PostController::class);
    });
