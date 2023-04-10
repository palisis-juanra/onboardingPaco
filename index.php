<?php 

// Include configuration
include("config/config.php");

// Include controller
include("controller/MainController.php");

$redis = new RedisService($REDIS_HOST, $REDIS_PORT, $REDIS_PASSWORD);

$mainController = new MainController($redis);
$sentChannels = $mainController->getAllChannels();

// Include views
include("view/template/header.php");

include("view/main_page.php");

include("view/template/footer.php");

?>