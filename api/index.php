<?php 
require 'vendor/autoload.php';

$app = new \Slim\Slim();

//http://hostname/api/
$app->get('/', function() use ($app){
    echo "Welcome to REST API";
});

//http:.../api/index.php/hello/Julio
$app->get('/hello/:name', function($name) use ($app){
    echo "Hi $name, welcome to the REST API's";
});

$app->run();
?>