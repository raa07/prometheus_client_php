<?php
require_once __DIR__ . '/vendor/autoload.php';

$redisAdapter = new \Prometheus\RedisAdapter('localhost');
$registry = new \Prometheus\Registry($redisAdapter);
$counter = $registry->registerGauge('test', 'some_gauge', 'it sets', ['type']);
$counter->set(234, ['type' => 'blue']);
$counter->set(123, ['type' => 'red']);

$counter = $registry->registerCounter('test', 'some_counter', 'it increases', ['type']);
$counter->increaseBy(123, ['type' => 'blue']);
$counter->increaseBy(65, ['type' => 'red']);

$histogram = $registry->registerHistogram('test', 'some_histogram', 'it observes', ['type'], [1, 2, 3.5, 4]);
$histogram->observe(3.1, ['type' => 'blue']);
$histogram->observe(1.1, ['type' => 'red']);

$registry->flush();
echo $registry->toText();
