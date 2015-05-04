<?php

require __DIR__ . '/model/Weather.php';

if (isset($_GET['history'])) {
    $history = Weather::getHistoryTemp($_GET['history']);
    header('Content-Type: application/json');
    $str = json_encode($history);
    echo $str;
} elseif (isset($_GET['weather'])) {
    header('Content-Type: application/json');
    echo json_encode(Weather::getWeather($_GET['weather']), JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
} elseif (isset($_GET['cities'])) {
    $cities = Weather::getCities();
    header('Content-Type: application/json');
    echo json_encode($cities);
} else {
    require __DIR__ . '/view/default.php';
}
