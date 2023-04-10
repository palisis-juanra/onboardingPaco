<?php

use TourCMS\Utils\TourCMS;

class Channel {

    private $tourcms;

    public function __construct() {

    }

	public function getTourCMS($channelId){
		$db = new DB($channelId);
		$this->tourcms = $db->getTourCMS();
	}

    public function showChannel($channelId) {
        $this->getTourCMS($channelId);
        return $this->tourcms->show_channel($channelId);
    }

}

?>