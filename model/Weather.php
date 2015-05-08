<?php

class Weather {

    public $city;
    public $temp;
    public $date;
    protected $message;
    protected static $server = 'http://pogoda.ngs.ru/json/';
    protected static $cities = ['nsk', 'kemerovo', 'krsk', 'omsk', 'tomsk', 'barnaul'];
    protected static $coord = [
        'kemerovo' => [55.39440246, 86.08778600],
        'nsk' => [55.00081759, 82.95627700],
        'krsk' => [56.02278829, 92.89742450], // Красноярск
        'omsk' => [55.12276857, 73.37843000],
        'tomsk' => [56.50682347, 84.97990300],
        'barnaul' => [53.31831663, 83.68515200]
    ];

    // данные с сервера НГС
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
        $result = file_get_contents(self::$server, false, $context);
        return json_decode($result, true);
    }

    // данные из БД
    public static function getHistoryTemp($city, $limit = 48) {
        try {
            $result = [];
            $m = new MongoClient();
            $db = $m->weather;
            $collection = $db->temp;
            $cursor = $collection->find(["city" => $city])->sort(["date" => -1])->limit($limit);
            date_default_timezone_set('Asia/Novosibirsk');
            foreach ($cursor as $document) {
                $result[] = [
                    "temp" => $document["temp"],
                    "date" => date('d-m-y H:i:s', $document["date"])
                ];
            }
        } catch (Exception $ex) {
            $result = null;
        }
        return $result;
    }

    // массив городов, координат и последнее значение температуры из БД
    public static function getCities() {
        try {
            $result = [];
            $m = new MongoClient();
            $db = $m->weather;
            $collection = $db->temp;
            foreach (self::$cities as $city) {
                $cursor = $collection->find(["city" => $city])->sort(["date" => -1])->limit(1);
                $result[] = [
                    'city' => $city,
                    'coord' => self::$coord[$city],
                    'temp' => str_replace('.', ',', $cursor->next()['temp'])
                ];
            }
        } catch (Exception $ex) {
            $result = [];
            foreach (self::$cities as $city) {
                $result[] = [
                    'city' => $city,
                    'coord' => self::$coord[$city],
                    'temp' => ''
                ];
            }
        }
        return $result;
    }

    // сохранение в БД
    public function save() {
        try {
            $m = new MongoClient();
            $db = $m->weather;
            $collection = $db->temp;
            $document = [
                "city" => $this->city,
                "temp" => (float) str_replace(',', '.', $this->temp),
                "date" => (int) $this->date
            ];
            $collection->insert($document);
            return true;
        } catch (Exception $ex) {
            $this->message = $ex->getMessage();
            return false;
        }
    }

    public static function getCitiesName() {
        return self::$cities;
    }

    public function getMessage() {
        return $this->message;
    }
}
