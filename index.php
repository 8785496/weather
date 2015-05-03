<?php

require __DIR__ . '/model/Weather.php';
//phpinfo();

if (isset($_GET['history'])) {
    //$str = file_get_contents('data.json');
    $arr = [
        ["date" => "1-05-15 05:00:00", "close" => 582.13],
        ["date" => "1-05-15 04:00:00", "close" => 583.98],
        ["date" => "1-05-15 03:00:00", "close" => 603.00],
        ["date" => "1-05-15 02:00:00", "close" => 607.70],
        ["date" => "1-05-15 01:00:00", "close" => 750.00]
    ];
    header('Content-Type: application/json');
    $str = json_encode($arr);
    echo $str;
} elseif (isset($_GET['weather'])) {
    header('Content-Type: application/json');
    echo json_encode(Weather::getWeather($_GET['weather']), JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
} else {
    require 'view/default.php';
}
