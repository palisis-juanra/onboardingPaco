<?php

include("config/config.php");
include("vendor/autoload.php");
include("model/DB.php");
include("service/ChannelService.php");
include("service/TourService.php");

class MainController
{

    const TOUR_EXPIRY_TIME = '+15 minutes';

    private $redis;

    public function __construct($redis)
    {
        $this->redis = $redis;
    }

    public function getAllChannels()
    {
        $channelService = new ChannelService();
        $sentChannels = [];
        foreach($GLOBALS["channels"] as $channelId => $privateKey) {
            $response = $channelService->show($channelId);
            $channel = $response->channel;
            $sentChannels[$channelId] = $channel->channel_name;
        }
        return $sentChannels;
    }

    public function listTours($channelId)
    {
        $tourService = new TourService();
        return $tourService->listTours($channelId);
    }

    public function showTour($tourId, $channelId)
    {
        $tourService = new TourService();
        return $tourService->showTour($tourId, $channelId);
    }

    public function getAllTours($channelId)
    {
        $toursFromChannel = $this->listTours($channelId);
        $tours = new SimpleXMLElement('<response />');
        $tours->addChild('error');

        $expire = MainController::TOUR_EXPIRY_TIME;
        $expireTime  = new \DateTime($expire);
        $expirationTimestamp = $expireTime->getTimestamp();

        if ($toursFromChannel->error == "OK") {
            unset($toursFromChannel->request);
            unset($toursFromChannel->error);

            foreach($toursFromChannel as $tourFromChannel) {
                $tourId = (int) $tourFromChannel->tour_id;

                $tourCacheKey = 'TOUR|'.$channelId.'|'.$tourId;
                $tourInfo;
                if ($this->redis->existKey($tourCacheKey)) {
                    $tourString = $this->redis->getItemFromRedis($tourCacheKey, RedisService::REDIS_TYPE_STRING);
                    $tourInfo = simplexml_load_string($tourString);
                } else {
                    $tourInfo = $this->showTour($tourId, $channelId);
                    if($tourInfo->error == "OK") {
                        $this->redis->storeItemInRedis($tourCacheKey, $tourInfo->asXML(), RedisService::REDIS_TYPE_STRING);
                        $this->redis->expireAt($tourCacheKey, $expirationTimestamp);
                    } else {
                        continue;
                    }
                }

                $tourInfo = $tourInfo->tour;

                $tour = $tours->addChild('tour');
                $tour->channel_id = $channelId;
                $tour->tour_id = $tourId;
                $tour->tour_name = (string) $tourInfo->tour_name;
                $tour->shortdesc = (string) $tourInfo->shortdesc;
                $tour->image_url = (string) $tourInfo->images->image->url;

            }

            $tours->error = "OK";
        } else {
            $tours->error = $toursFromChannel->error;
        }

        return $tours;
    }

    public function xml2array ($xmlObject, $out = [])
    {
        foreach ( (array) $xmlObject as $index => $node ) {
            $out[$index] = ( is_object ( $node ) ) ? $this->xml2array ( $node ) : $node;
        }
        return $out;
    }

    public function printArray(array $nodes, int $indentation = 0, array $countArray = [], bool $isXML = false)
    {
        foreach ($nodes as $index => $node) {
            if(is_a($node, 'SimpleXMLElement')) {
                $node = $this->xml2array($node);
                $isXML = true;
            } else {
                print_r("<div class='col-12'>");
                print_r("<p><strong class='font-weight-bold text-dark'>$index:</strong> $node</p>");
                print_r("</div>");
            }
            if(is_array($node)) {
                $this->printArray($node, $indentation, $countArray);
            }
        }
    }
    // public function printArray(array $nodes, int $indentation = 0, int $count = 0, bool $isXML = false)
    // {
    //     foreach ($nodes as $index => $node) {
    //         // error_log("INDEX: $index; NODE: $node; COUNT: $count");
    //         print_r("INDENTATION: $indentation; COUNT: $count;<br>");
    //         // $nodeString = is_array($node) ? 'Array' : $node;
    //         if(is_a($node, 'SimpleXMLElement')) {
    //             $node = $this->xml2array($node);
    //             $isXML = true;
    //         } else {
    //             print_r("<div class='col-12'>");
    //             $pixels = 20 * $indentation;
    //             print_r("<p style='margin-left: ".$pixels."px;'><strong class='font-weight-bold text-dark'>$index:</strong> $node</p>");
    //             print_r("</div>");
    //         }
            
    //         if(is_array($node)) {
    //             $count = count($node);
    //             if($count > 0)  {
    //                 if (!$isXML) $indentation++;
    //                 $this->printArray($node, $indentation, $count);
    //             }
    //         }
    //         if ($count > 0) $count--;
    //         if ($count === 0 && $indentation > 0) $indentation--;
    //     }
    // }

    public function getFullHourByMinutes(int $minutes)
    {
        $hours = floor($minutes / 60);
        $minutes = $minutes - $hours * 60;
        if (strlen((string)$hours) == 1) {
            $hours = "0".$hours;
        }
        if (strlen((string)$minutes) == 1) {
            $minutes = "0".$minutes;
        }
        return "$hours:$minutes";
    }

    public function updateTour($tourData, $channelId)
    {
        $tourService = new TourService();
        return $tourService->updateTour($tourData, $channelId);
    }

}


?>