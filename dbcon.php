<?php

require __DIR__.'/vendor/autoload.php';

use Kreait\Firebase\Factory;

$factory = (new Factory)
->withServiceAccount('fixitfinder-b2329-firebase-adminsdk-g8tpg-b8a0084451.json')
->withDatabaseUri('https://fixitfinder-b2329-default-rtdb.firebaseio.com/');

$database = $factory->createDatabase();
$auth = $factory->createAuth();

?>