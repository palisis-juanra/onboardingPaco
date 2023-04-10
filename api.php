<?php

// Include configuration
include("config/config.php");

include("controller/MainController.php");

$redis = new RedisService($REDIS_HOST, $REDIS_PORT, $REDIS_PASSWORD);

$mainController = new MainController($redis);

$path = explode('/', parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
$path = end($path);
$query = parse_url($_SERVER['REQUEST_URI'], PHP_URL_QUERY);
$method = $_SERVER['REQUEST_METHOD'];
$postData = $_POST;

error_log(print_r($_SERVER, true), 3, "log.log");
error_log("--------------------\r\n", 3, "log.log");
error_log(print_r($_POST, true), 3, "log.log");

// error_log($path);
// error_log($method);
// error_log($query);

function printResponseAndOK($response) {
    print_r($response->asXML());
    header("HTTP/1.1 200 OK");
    exit();
}

if(isset($path) && isset($method)) {

    $queryTemp = explode('&', $query);
    $queryFinal = [];
    foreach($queryTemp as $temp) {
        $tempFinal = explode('=', $temp);
        $queryFinal[$tempFinal[0]] = $tempFinal[1];
    }
    // print_r($queryFinal);
    
    if(isset($query) && $method == 'GET' && $path == 'listTours') {
        foreach($queryFinal as $key => $val) {
            if($key == 'channelId' && is_numeric($val)) {
                $tours = $mainController->listTours($val);
                printResponseAndOK($tours);
            } 
        }
    }
    
    if(isset($query) && $method == 'GET' && $path == 'showTour') {
        $found = 0;
        $channelId;
        $tourId;
        foreach($queryFinal as $key => $val) {
            if($key == 'channelId' && is_numeric($val)) {
                $channelId = $val;
                $found++;
            } else if($key == 'tourId' && is_numeric($val)) {
                $tourId = $val;
                $found++;
            }
            if($found >= 2) {
                break;
            }
        }
        if($channelId && $tourId) {
            $tour = $mainController->showTour($tourId, $channelId);
            printResponseAndOK($tour);
        }
    }

    if(isset($query) && $method == 'GET' && $path == 'getAllTours') {
        foreach($queryFinal as $key => $val) {
            if($key == 'channelId' && is_numeric($val)) {
                $tours = $mainController->getAllTours($val);
                printResponseAndOK($tours);
            } 
        }
    }

    if($method == 'POST' && $path == 'updateTour') {
        $response = $mainController->updateTour($postData, $channelId);
        $response = "";

        printResponseAndOK($response);
    }

    header("HTTP/1.1 404 Not Found");
    exit();
} else {
    header("HTTP/1.1 404 Not Found");
    exit();
}

?>