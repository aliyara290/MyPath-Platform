<?php

use App\Http\Controllers\V1\Auth\AuthController;
use App\Http\Controllers\V1\Auth\ForgetPasswordController;
use App\Http\Controllers\V1\Auth\ResetPasswordController;
use App\Http\Controllers\V1\CategoryController;
use App\Http\Controllers\V1\UserProfileController;
use App\Http\Controllers\V1\CourseController;
use App\Http\Controllers\V1\TagController;
use App\Http\Controllers\V1\VideoController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::group(["prefix" => "v1"], function () {
    Route::group(["prefix" => "auth"], function () {
        Route::post("/login", [AuthController::class, "login"]);
        Route::post("/register", [AuthController::class, "register"]);

        Route::middleware("web")->group(function () {
            Route::get("/login/google", [AuthController::class, "redirectToGoogle"]);
            Route::get("/login/google/callback", [AuthController::class, "handleGoogleCallback"]);
        });

        Route::post("/forget-password", [ForgetPasswordController::class, "sendResetLink"]);
        Route::post("/reset-password", [ResetPasswordController::class, "resetPassword"]);

        Route::group(["middleware" => ["auth:sanctum"]], function () {
            Route::post("/logout", [AuthController::class, "destroy"]);
            Route::get("/user", [UserProfileController::class, "getAuthUser"]);
            Route::post("/user/update", [UserProfileController::class, "updateAuthUser"]);
        });
    });

    Route::group(["middleware" => ["auth:sanctum"]], function () {
        Route::post("/refresh-token", [AuthController::class, "refreshToken"]);
        Route::apiResource("/categories", CategoryController::class);
        Route::apiResource("/courses", CourseController::class);
        Route::apiResource("/tags", TagController::class);
        Route::apiResource("/videos", VideoController::class);
    });
});