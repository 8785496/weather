<?php

//phpinfo();

if (isset($_GET['city'])) {
    //$str = file_get_contents('data.json');
    $arr = [
        ["date" => "1-May-12", "close" => 582.13],
        ["date" => "30-Apr-12", "close" => 583.98],
        ["date" => "27-Apr-12", "close" => 603.00],
        ["date" => "26-Apr-12", "close" => 607.70],
        ["date" => "25-Apr-12", "close" => 750.00]
    ];
    $str = json_encode($arr);
    echo $str;
} else {
    require 'view/default.php';
}
