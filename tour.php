<?php

// Include configuration
include("config/config.php");

// Include controller
include("controller/MainController.php");

$redis = new RedisService($REDIS_HOST, $REDIS_PORT, $REDIS_PASSWORD);

$mainController = new MainController($redis);

$tour = $mainController->showTour($_GET['tourId'], $_GET['channelId'])->tour;
$tour = $mainController->xml2array($tour);

if (!array_key_exists('start_time', $tour)) $tour['start_time'] = 'NOTSET';
if (!array_key_exists('end_time', $tour)) $tour['end_time'] = 'NOTSET';

// Include views
include("view/template/header.php");

include("view/tour_page.php");

include("view/template/footer.php");

?>