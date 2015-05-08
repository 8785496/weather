<?php

class Weather_mysql extends Weather {

    private static $host = 'localhost';
    private static $dbname = 'weather';
    private static $username = 'root';
    private static $password = '';

    // данные из БД
    public static function getHistoryTemp($city, $limit = 48) {
        try {
            $result = [];
            $dbh = new PDO('mysql:host=' . self::$host . ';dbname=' . self::$dbname, self::$username, self::$password);
            $stmt = $dbh->prepare('SELECT * FROM temp WHERE city=:city ORDER BY `date` DESC LIMIT :limit');
            $stmt->bindParam(':city', $city, PDO::PARAM_STR);
            $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
            $stmt->execute();
            date_default_timezone_set('Asia/Novosibirsk');
            while ($row = $stmt->fetch()) {
                $result[] = [
                    "temp" => $row["temp"],
                    "date" => date('d-m-y H:i:s', $row["date"])
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
            $dbh = new PDO('mysql:host=' . self::$host . ';dbname=' . self::$dbname, self::$username, self::$password);
            $stmt = $dbh->prepare('SELECT * FROM temp WHERE city=:city ORDER BY `date` DESC LIMIT 1');
            foreach (self::$cities as $city) {
                $stmt->bindParam(':city', $city, PDO::PARAM_STR);
                $stmt->execute();
                $result[] = [
                    'city' => $city,
                    'coord' => self::$coord[$city],
                    'temp' => str_replace('.', ',', $stmt->fetch()['temp'])
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
            $dbh = new PDO('mysql:host=' . self::$host . ';dbname=' . self::$dbname, self::$username, self::$password);
            $stmt = $dbh->prepare('INSERT INTO temp (city, temp, `date`) VALUES (:city, :t, :d)');
            $stmt->bindParam(':city', $this->city, PDO::PARAM_STR);
            $stmt->bindParam(':t', str_replace(',', '.', $this->temp), PDO::PARAM_STR);
            $stmt->bindParam(':d', $this->date, PDO::PARAM_INT);
            $stmt->execute();
        } catch (Exception $ex) {
            print_r($ex);
            return false;
        }
    }

}
