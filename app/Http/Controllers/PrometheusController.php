<?php

namespace App\Http\Controllers;

use Prometheus\CollectorRegistry;
use Prometheus\RenderTextFormat;

class PrometheusController extends Controller
{
    public function metrics(CollectorRegistry $registry)
    {
        $renderer = new RenderTextFormat();
        $result =  $renderer->render($registry->getMetricFamilySamples());
        header('Content-type: ' . RenderTextFormat::MIME_TYPE);
        echo $result;die();
    }

    public function counter(CollectorRegistry $registry)
    {
        $counter = $registry->getOrRegisterCounter('test', 'some_counter', 'it increases', ['type']);
        $counter->incBy(5, ['blue']);
    }

    public function gauge(CollectorRegistry $registry)
    {
        $gauge = $registry->getOrRegisterGauge('test', 'some_gauge', 'it sets', ['type']);
        $gauge->set(2.5, ['blue']);
    }

    public function histogram(CollectorRegistry $registry)
    {
        $histogram = $registry->getOrRegisterHistogram('test', 'some_histogram', 'it observes', ['type'], [0.1, 1, 2, 3.5, 4, 5, 6, 7, 8, 9]);
        $histogram->observe(3.5, ['blue']);
    }

    public function summary(CollectorRegistry $registry)
    {
        $summary = $registry->getOrRegisterSummary('test', 'some_summary', 'it observes a sliding window', ['type'], 84600, [0.01, 0.05, 0.5, 0.95, 0.99]);
        $summary->observe(5, ['blue']);
    }
}
