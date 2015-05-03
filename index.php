<?php

require __DIR__ . '/model/Weather.php';
//phpinfo();

if (isset($_GET['history'])) {
    //$str = file_get_contents('data.json');
    $arr = [
        ["date" => "1-05-15 00:00:00", "close" => 3],
        ["date" => "1-05-15 01:00:00", "close" => 3],
        ["date" => "1-05-15 02:00:00", "close" => 4],
        ["date" => "1-05-15 03:00:00", "close" => 4],
        ["date" => "1-05-15 04:00:00", "close" => 4],
        ["date" => "1-05-15 05:00:00", "close" => 5],
        ["date" => "1-05-15 06:00:00", "close" => 6],
        ["date" => "1-05-15 07:00:00", "close" => 7],
        ["date" => "1-05-15 08:00:00", "close" => 8],
        ["date" => "1-05-15 09:00:00", "close" => 9],
        ["date" => "1-05-15 10:00:00", "close" => 10],
        ["date" => "1-05-15 11:00:00", "close" => 11],
        ["date" => "1-05-15 12:00:00", "close" => 12],
        ["date" => "1-05-15 13:00:00", "close" => 12],
        ["date" => "1-05-15 14:00:00", "close" => 12],
        ["date" => "1-05-15 15:00:00", "close" => 11],
        ["date" => "1-05-15 16:00:00", "close" => 10],
        ["date" => "1-05-15 17:00:00", "close" => 9],
        ["date" => "1-05-15 18:00:00", "close" => 8],
        ["date" => "1-05-15 19:00:00", "close" => 7],
        ["date" => "1-05-15 20:00:00", "close" => 6],
        ["date" => "1-05-15 21:00:00", "close" => 5],
        ["date" => "1-05-15 22:00:00", "close" => 4],
        ["date" => "1-05-15 23:00:00", "close" => 4]
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
