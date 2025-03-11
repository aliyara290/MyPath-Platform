<?php

use App\Http\Controllers\V1\CategoryController;
use App\Http\Controllers\V1\CourseController;
use App\Http\Controllers\V1\TagController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');



Route::apiResource("/categories", CategoryController::class);
Route::apiResource("/courses", CourseController::class);
Route::apiResource("/tags", TagController::class);