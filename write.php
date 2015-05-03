<?php
//echo "3\n";

// connect
$m = new MongoClient();

// select a database
$db = $m->weather;

// select a collection (analogous to a relational database's table)
$collection = $db->data;

// add a record
$document = [
    "time" => time(), 
    "temp" => 10 
];
$collection->insert($document);

$cursor = $collection->find();

// iterate through the results
foreach ($cursor as $document) {
    echo "{$document["time"]} - {$document["temp"]}\n";
}
