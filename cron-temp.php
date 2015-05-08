<?php

require __DIR__ . '/model/Weather.php';

$cities = Weather::getCitiesName();
date_default_timezone_set('Asia/Novosibirsk');
foreach ($cities as $city) {
    $data = Weather::getWeather($city);
    $weather = new Weather();
    $weather->city = $city;
    $weather->temp = $data['result']['temp_current_c'];
    $weather->date = $data['result']['last_success_update_date'];
    if (!$weather->save()) {
        echo date('d.m.y H:i:s') . ' ' . $weather->getMessage() . "\n";
    }
}
