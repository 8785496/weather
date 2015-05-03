<?php

class Weather {
    public $city;
    public $temp;
    public $date;

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
    
    public static function getCurrentTemp($city){
        $data = self::getWeather($city);
        $result['last_success_update_date'] = $data['result']['last_success_update_date'];
        $result['temp_current_c'] = $data['result']['temp_current_c'];
        return $result;
    }
    
    public function save(){
        // connect
        $m = new MongoClient();

        // select a database
        $db = $m->weather;

        // select a collection (analogous to a relational database's table)
        $collection = $db->temp;

        // add a record
        $document = [
            "city" => $this->city,
            "temp" => $this->temp,
            "date" => $this->date
        ];
        $collection->insert($document);
    }
}
