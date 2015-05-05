<?php
require __DIR__ . '/model/Weather.php';

$cities = Weather::getCitiesName();

foreach ($cities as $city) {
    $data = Weather::getWeather($city);
    $weather = new Weather();
    $weather->city = $city;
    $weather->temp = $data['result']['temp_current_c'];
    $weather->date = $data['result']['last_success_update_date'];
    $weather->save();
}
