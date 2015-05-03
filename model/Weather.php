<?php

class Weather {

    private static $server = 'http://pogoda.ngs.ru/json/';

    public static function getWeather($city) {
        $request = [
            'method' => 'getForecast',
            'params' => [
                'name' => 'current',
                'city' => $city
            ]
        ];
        $content = json_encode($request);
        $opts = [
            'http' => [
                'method' => "POST",
                'content' => $content
            ]
        ];
        $context = stream_context_create($opts);
        $result = file_get_contents(self::$server, 0, $context);
        return json_decode($result, true);
    }
}
