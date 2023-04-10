<?php

use TourCMS\Utils\TourCMS;

class Tour {

    private $tourcms;

    public function __construct() {

    }

	public function getTourCMS($channelId) {
		$db = new DB($channelId);
		$this->tourcms = $db->getTourCMS();
	}

    public function listTours($channelId) {
        $this->getTourCMS($channelId);
        return $this->tourcms->list_tours($channelId);
    }
    
    public function showTour($tourId, $channelId) {
        $this->getTourCMS($channelId);
        return $this->tourcms->show_tour($tourId, $channelId);
    }

    public function updateTour($tourData, $channelId) {
        $this->getTourCMS($channelId);

        // Create tour data
        $finalTourData = new SimpleXMLElement('<tour />');
        // $tour_data->addChild('tour_id', '$tour');
        // $tour_data->addChild('start_time_default', '9:00');
        // $tour_data->addChild('end_time_default', '17:00');

        return $this->tourcms->update_tour($finalTourData, $channelId);
    }

}

?>