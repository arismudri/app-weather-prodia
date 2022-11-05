<?php

use App\Http\Controllers\Auth\AuthenticationController;
use App\Http\Controllers\Home\HomeController;
use App\Http\Controllers\Weather\WeatherController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [HomeController::class, "index"]);
Route::get('/weather/detail-view/{id}', [WeatherController::class, "detailView"]);
Route::get('/login-view', [AuthenticationController::class, "loginView"]);
Route::get('/register-view', [AuthenticationController::class, "registerView"]);
