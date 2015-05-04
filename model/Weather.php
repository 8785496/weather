<?php

class Weather {

    public $city;
    public $temp;
    public $date;
    private static $server = 'http://pogoda.ngs.ru/json/';
    private static $cities = ['nsk', 'kemerovo', 'krsk', 'omsk', 'tomsk', 'barnaul'];
    private static $coord = [
        'kemerovo' => [55.39440246, 86.08778600],
        'nsk' => [55.00081759, 82.95627700],
        'krsk' => [56.02278829, 92.89742450], // Красноярск
        'omsk' => [55.12276857, 73.37843000],
        'tomsk' => [56.50682347, 84.97990300],
        'barnaul' => [53.31831663, 83.68515200]
    ];

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

    public static function getCurrentTemp($city) {
        $data = self::getWeather($city);
        $result['last_success_update_date'] = $data['result']['last_success_update_date'];
        $result['temp_current_c'] = $data['result']['temp_current_c'];
        return $result;
    }

    public static function getHistoryTemp($city, $limit = 48) {
        $m = new MongoClient();
        $db = $m->weather;
        $collection = $db->temp;
        $cursor = $collection->find(["city" => $city])->sort(["date" => -1])->limit($limit);
        $result = [];
        foreach ($cursor as $document) {
            $result[] = [
                "temp" => $document["temp"],
                "date" => date('d-m-y H:i:s', $document["date"])
            ];
        }
        return $result;
    }
    
    public static function getCities(){
        $m = new MongoClient();
        $db = $m->weather;
        $collection = $db->temp;
        $result = [];
        foreach (self::$cities as $city) {
            $cursor = $collection->find(["city" => $city])->sort(["date" => -1])->limit(1);
            $result[] = [
                'city' => $city,
                'coord' => self::$coord[$city],
                'temp' => str_replace('.', ',', $cursor->next()['temp'])
            ];
        }
        return $result;
    }

    public function save() {
        $m = new MongoClient();
        $db = $m->weather;
        $collection = $db->temp;
        $document = [
            "city" => $this->city,
            "temp" => (float) str_replace(',', '.', $this->temp),
            "date" => (int) $this->date
        ];
        $collection->insert($document);
    }
    
    public static function getCitiesName(){
        return self::$cities;
    }
}
