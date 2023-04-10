<?php

include("config/config.php"); 
include("vendor/autoload.php");

use TourCMS\Utils\TourCMS;

class DB {

    private $privateKey;
    private $baseUrl = "http://192.168.56.74:80/api.tourcms.com";
    private $marketplaceId = 0;
    private $resultType = "simplexml";

    public function __construct($channelId) {
        $this->privateKey = $this->getPrivateKey($channelId);
    }

    public function getPrivateKey($channelId) {
        return $GLOBALS["channels"][$channelId];
    }

    public function getTourCMS() {
        $tourcms = new TourCMS($this->marketplaceId, $this->privateKey, $this->resultType);
        $tourcms->set_base_url($this->baseUrl);
        return $tourcms;
    }

}

?>