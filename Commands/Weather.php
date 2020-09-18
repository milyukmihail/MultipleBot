<?php


class Weather {
    
    /**
     *
     * @var type object Guzzle
     */
    private $object;
    
    public function __construct($city) {
        $client = new \GuzzleHttp\Client();
        
        $url = 'http://api.openweathermap.org/data/2.5/forecast?q=' . $city . '&units=metric&lang=ru&appid=TOKEN';
        
        $res = $client->request('GET', $url);
        
        $this->object = json_decode($res->getBody());    
    }
    
    /**
     * Get weather
     * @param type $object
     * @return type array
     */
    public function getWeatherOnTime($object) {
        return $data = [
            "Temperature" => $this->getTemperature($object),
            "Description" => $this->getDescription($object),
            "Windspeed" => $this->getWindSpeed($object) . " м/с ",
            "Emoji" => $this->getEmoji($object)
        ];
    }

    /**
     * 
     * @param type $object
     * @return string emoji
     */
    public function getEmoji($object)
    {
        if($object->weather[0]->icon === "01d"){ return "\xE2\x98\x80\xEF\xB8\x8F";}
        if($object->weather[0]->icon === "02d"){ return "\xE2\x9B\x85";}
        if($object->weather[0]->icon === "03d"){ return "\xE2\x98\x81\xEF\xB8\x8F";}
        if($object->weather[0]->icon === "04d"){ return "\xE2\x98\x81\xEF\xB8\x8F \xE2\x98\x81\xEF\xB8\x8F";}
        if($object->weather[0]->icon === "09d"){ return "\xF0\x9F\x8C\xA7\xEF\xB8\x8F";}
        if($object->weather[0]->icon === "10d"){ return "\xF0\x9F\x8C\xA6\xEF\xB8\x8F";}
        if($object->weather[0]->icon === "11d"){ return "\xE2\x9B\x88\xEF\xB8\x8F";}
        if($object->weather[0]->icon === "13d"){ return "\xE2\x9D\x84\xEF\xB8\x8F";}
        if($object->weather[0]->icon === "50d"){ return "\xF0\x9F\x8C\xAB\xEF\xB8\x8F";}
        if($object->weather[0]->icon === "01n"){ return "\xF0\x9F\x8C\x91";}
        if($object->weather[0]->icon === "02n"){ return "\xE2\x98\x80\xEF\xB8\x8F \xE2\x98\x81\xEF\xB8\x8F";}
        if($object->weather[0]->icon === "03n"){ return "\xE2\x98\x81\xEF\xB8\x8F";}
        if($object->weather[0]->icon === "04n"){ return "\xE2\x98\x81\xEF\xB8\x8F \xE2\x98\x81\xEF\xB8\x8F";}
        if($object->weather[0]->icon === "09n"){ return "\xF0\x9F\x8C\xA7\xEF\xB8\x8F";}
        if($object->weather[0]->icon === "10n"){ return "\xF0\x9F\x8C\xA6\xEF\xB8\x8F";}
        if($object->weather[0]->icon === "11n"){ return "\xE2\x9B\x88\xEF\xB8\x8F";}
        if($object->weather[0]->icon === "13n"){ return "\xE2\x9D\x84\xEF\xB8\x8F";}
        if($object->weather[0]->icon === "50n"){ return "\xF0\x9F\x8C\xAB\xEF\xB8\x8F";}
        else{ return "\xF0\x9F\x8D\x80";}
    }
    
    /**
     * 
     * @param type $object
     * @return type string
     */
    public function getWindSpeed($object)
    {
        return $object->wind->speed;
    }
    
    /**
     * 
     * @param type $object
     * @return type string
     */
    public function getDescription($object)
    {
        return $object->weather[0]->description;
    }
    
    /**
     * 
     * @param type $object
     * @return type string
     */
    public function getTemperature($object)
    {
        $feels_like = (int) $object->main->feels_like;
        
        return $feels_like = $feels_like . " °С";
    }
    
    /**
     * 
     * @return type object
     */
    public function getFirstObject()
    {
        return $this->object->list[0];
    }
    
    /**
     * 
     * @param type $date string
     * @return type object
     */
    public function getObjectWeatherForDate($date)
    {
        for($i = 0; $i <= 39; $i++)
        {
            if($this->object->list[$i]->dt_txt === $date)
            {
                return $this->object->list[$i];
            }
        }
    }
    
    /**
     * 
     * @return type object
     */
    public function getObjectInMiddle()
    {
        for($i = 0; $i <= 39; $i++)
        {
            if($this->object->list[$i]->dt_txt === ($this->getCurrentDate() . " 15:00:00"))
            {
                return $this->object->list[$i];
            }
        }
    }
    
    /**
     * 
     * @return type string
     */
    public function getDateTomorrowNight()
    {
        return date("Y-m-d", strtotime("+2 day")) . " 03:00:00";
    }
    
    /**
     * 
     * @return type string
     */
    public function getDateAfterTomorrowDay()
    {
        return date("Y-m-d", strtotime("+2 day")) . " 15:00:00";
    }
    
    /**
     * 
     * @return type string
     */
    public function getDateTomorrowDay()
    {
        return date("Y-m-d", strtotime("+1 day")) . " 15:00:00";
    }
    
    /**
     * 
     * @return type string
     */
    public function getDateThisNight()
    {
        return date("Y-m-d", strtotime("+1 day")) . " 03:00:00";
    }
    
    /**
     * 
     * @return type string
     */
    public function getTimeFifteen()
    {
        return date("15:00:00");
    }
    
    /**
     * 
     * @return type string
     */
    public function getCurrentDate()
    {
        return date("Y-m-d");
    }
    
    /**
     * 
     * @return type string
     */
    public function getCurrentTime()
    {
        return date("H:00:00");
    }
    
}
