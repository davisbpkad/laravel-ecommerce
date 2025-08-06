<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\PlaceholderController;

Route::apiResource('categories', CategoryController::class);

// Placeholder image routes
Route::get('placeholder/{width}/{height?}', [PlaceholderController::class, 'image'])
    ->where(['width' => '[0-9]+', 'height' => '[0-9]+']);

Route::get('placeholder/svg/{width}/{height?}', [PlaceholderController::class, 'svg'])
    ->where(['width' => '[0-9]+', 'height' => '[0-9]+']);
