<?php

use Illuminate\Support\Facades\Route;
use Prometheus\CollectorRegistry;
use Prometheus\RenderTextFormat;
use Prometheus\Storage\InMemory;
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

Route::get('/metrics', function (CollectorRegistry $registry) {
    $renderer = new RenderTextFormat();
    $result =  $renderer->render($registry->getMetricFamilySamples());
    header('Content-type: ' . RenderTextFormat::MIME_TYPE);
    echo $result;die();

});

Route::get('/counter' , function (CollectorRegistry $registry) {
    $counter = $registry->getOrRegisterCounter('test', 'some_counter', 'it increases', ['type']);

    while (true) {
        $counter->incBy(5, ['blue']);
    }
});

Route::get('/gauge' , function (CollectorRegistry $registry) {
    $gauge = $registry->getOrRegisterGauge('test', 'some_gauge', 'it sets', ['type']);
    $gauge->set(2.5, ['blue']);
});

Route::get('/histogram' , function (CollectorRegistry $registry) {
    $histogram = $registry->getOrRegisterHistogram('test', 'some_histogram', 'it observes', ['type'], [0.1, 1, 2, 3.5, 4, 5, 6, 7, 8, 9]);
    $histogram->observe(3.5, ['blue']);
});

Route::get('/summary' , function (CollectorRegistry $registry) {
    $summary = $registry->getOrRegisterSummary('test', 'some_summary', 'it observes a sliding window', ['type'], 84600, [0.01, 0.05, 0.5, 0.95, 0.99]);
    $summary->observe(5, ['blue']);
});


