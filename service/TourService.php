<?php

include("model/Tour.php"); 

class TourService {

    private $tour;

    public function __construct() {
		$this->tour = new Tour();
	}

    public function listTours($channelId) {
        return $this->tour->listTours($channelId);
    }

    public function showTour($tourId, $channelId) {
        return $this->tour->showTour($tourId, $channelId);
    }

    public function updateTour($tourData, $channelId) {
        return $this->tour->updateTour($tourData, $channelId);
    }

}


?>