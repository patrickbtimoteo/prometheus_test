<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use Prometheus\CollectorRegistry;
use Prometheus\RenderTextFormat;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::name('api.')->namespace('Api')->group(function(){
    Route::post('v1/query', function (CollectorRegistry $registry) {
        $renderer = new RenderTextFormat();
        $result =  $renderer->render($registry->getMetricFamilySamples());
        header('Content-type: ' . RenderTextFormat::MIME_TYPE);
        echo $result;die();
    });
});
