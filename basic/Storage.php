<?php

include 'vendor/predis/predis/autoload.php';

Predis\Autoloader::register();

class Storage {
    
    /**
     * @var type object
     */
    public $client;
    
    /*
     * @var type int
     */
    public $chatid;
    
    /**
     * Redis object
     */
    public function __construct() {
        $this->client = new Predis\Client();
    }

    /** 
     * Push message in redis
     * @param type $messagestring 
     */
    public function pushMessagestring($messagestring)
    {
        $this->client->set($this->chatid, $messagestring);
    }
    
    /**
     * Take the late message from redis
     */
    public function getLastMessage()
    {
        return $this->client->get($this->chatid);
    }
}
