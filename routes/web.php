<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PrometheusController;

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

Route::get('/metrics' , [PrometheusController::class, 'metrics']);
Route::get('/counter' , [PrometheusController::class, 'counter']);
Route::get('/gauge' , [PrometheusController::class, 'gauge']);
Route::get('/histogram' , [PrometheusController::class, 'histogram']);
Route::get('/summary' , [PrometheusController::class, 'summary']);
