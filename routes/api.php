<?php

use App\Http\Controllers\Auth\AuthenticationController;
use App\Http\Controllers\Weather\WeatherController;
use App\Http\Controllers\Transaction\TransactionProductController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


Route::post("register", [AuthenticationController::class, "register"]);
Route::post("login", [AuthenticationController::class, "login"]);

Route::group(["middleware" => ["jwt.verify"]], function () {
    Route::get("logout", [AuthenticationController::class, "logout"]);
    Route::get("user-info", [AuthenticationController::class, "userInfo"]);

    Route::group(["middleware" => ["jwt.verify"], "prefix" => "weather"], function () {
        Route::get("", [WeatherController::class, "index"]);
        Route::get("{id}", [WeatherController::class, "show"]);
        Route::post("", [WeatherController::class, "store"]);
        Route::put("{id}", [WeatherController::class, "update"]);
        Route::delete("{id}", [WeatherController::class, "destroy"]);
    });
});

Route::group(["prefix" => "weather", "middleware" => ["jwt.verify"]], function () {
    Route::get("", [WeatherController::class, "index"]);
    Route::get("{id}", [WeatherController::class, "show"]);
    Route::get("/get/datatable", [WeatherController::class, "datatable"]);
    Route::post("", [WeatherController::class, "store"]);
    Route::put("{id}", [WeatherController::class, "update"]);
    Route::delete("{id}", [WeatherController::class, "destroy"]);
});
