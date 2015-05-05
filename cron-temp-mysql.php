<?php
require __DIR__ . '/model/Weather.php';
require __DIR__ . '/model/Weather_mysql.php';


$cities = Weather_mysql::getCitiesName();

foreach ($cities as $city) {
    $data = Weather_mysql::getWeather($city);
    $weather = new Weather_mysql();
    $weather->city = $city;
    $weather->temp = $data['result']['temp_current_c'];
    $weather->date = $data['result']['last_success_update_date'];
    $weather->save();
}
