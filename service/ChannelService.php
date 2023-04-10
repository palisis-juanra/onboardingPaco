<?php

include("model/Channel.php"); 

class ChannelService {

    private $channel;

    public function __construct() {
		$this->channel = new Channel();
	}

    public function show($channelId) {
        return $this->channel->showChannel($channelId);
    }

}


?>