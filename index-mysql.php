<?php

require __DIR__ . '/model/Weather.php';
require __DIR__ . '/model/Weather_mysql.php';

if (isset($_GET['history'])) {
    $history = Weather_mysql::getHistoryTemp($_GET['history']);
    header('Content-Type: application/json');
    $str = json_encode($history);
    echo $str;
} elseif (isset($_GET['weather'])) {
    header('Content-Type: application/json');
    echo json_encode(Weather::Weather_mysql($_GET['weather']), JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
} elseif (isset($_GET['cities'])) {
    $cities = Weather_mysql::getCities();
    header('Content-Type: application/json');
    echo json_encode($cities);
} else {
    require __DIR__ . '/view/default.php';
}
