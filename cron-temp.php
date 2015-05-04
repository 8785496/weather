<?php
require __DIR__ . '/model/Weather.php';

//$cities = ['nsk', 'kemerovo', 'krsk', 'omsk', 'tomsk', 'barnaul'];

$cities = Weather::getCitiesName();

foreach ($cities as $city) {
    $data = Weather::getCurrentTemp($city);
    $weather = new Weather();
    $weather->city = $city;
    $weather->temp = $data['temp_current_c'];
    $weather->date = $data['last_success_update_date'];
    $weather->save();
}


//// connect
//$m = new MongoClient();
////
//// select a database
//$db = $m->weather;
////
//// select a collection (analogous to a relational database's table)
//$collection = $db->temp;
//
//$cursor = $collection->find();
//
//// iterate through the results
//foreach ($cursor as $document) {
//    echo "{$document["city"]} - {$document["temp"]} - {$document["date"]}<br>";
//}
