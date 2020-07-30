<?php

namespace Telegram\Bot\Commands;

include 'Commands\Weather.php';

use Telegram\Bot\Actions;
use Telegram\Bot\Commands\Command;

class WeatherCommand extends Command {

    /**
     *
     * @var type string
     */
    protected $name = 'weather';

    /**
     *
     * @var type string
     */
    protected $description = 'Узнать погоду';

    /**
     * 
     * @inheritdoc
     */
    public function handle($arguments)
    {
        date_default_timezone_set('Europe/Minsk');
        
        $weather = new \Weather($arguments);
        
        $object_now = $weather->getFirstObject();
        $data_now = $weather->getWeatherOnTime($object_now);
         
        $date_fifteen = $weather->getCurrentDate() . " " . $weather->getTimeFifteen();
        $object_fifteen = $weather->getObjectWeatherForDate($date_fifteen);
        $data_fifteen = $weather->getWeatherOnTime($object_fifteen);
        
        $date_this_night = $weather->getDateThisNight();
        $object_this_night = $weather->getObjectWeatherForDate($date_this_night);
        $data_this_night = $weather->getWeatherOnTime($object_this_night);
        
        $date_tom_day = $weather->getDateTomorrowDay();
        $object_tom_day = $weather->getObjectWeatherForDate($date_tom_day);
        $data_tom_day = $weather->getWeatherOnTime($object_tom_day);
        
        $date_after_tom_day = $weather->getDateAfterTomorrowDay();
        $object_after_tom_day = $weather->getObjectWeatherForDate($date_after_tom_day);
        $data_after_tom_day = $weather->getWeatherOnTime($object_after_tom_day);
        
        $date_tom_night = $weather->getDateTomorrowNight();
        $object_tom_night = $weather->getObjectWeatherForDate($date_tom_night);
        $data_tom_night = $weather->getWeatherOnTime($object_tom_night);
        
        $now = "\n" . "Сейчас " . $data_now["Temperature"] . ", " . $data_now["Description"] . ", скорость ветра " . $data_now["Windspeed"] . $data_now["Emoji"];       
        
        $fifteen = "\n" . "Сегодня днем " . $data_fifteen["Temperature"] . ", " . $data_fifteen["Description"] . ", скорость ветра " . $data_fifteen["Windspeed"] . $data_fifteen["Emoji"];
        
        $this_night = "\n" . "Ночью " . $data_this_night["Temperature"] . ", " . $data_this_night["Description"] . ", скорость ветра " . $data_this_night["Windspeed"] . $data_this_night["Emoji"];
        
        $tom_day = "\n" . "Завтра днем " . $data_tom_day["Temperature"] . ", " . $data_tom_day["Description"] . ", скорость ветра " . $data_tom_day["Windspeed"] . $data_tom_day["Emoji"];
        
        $after_tom_night = "\n" . "Завтра ночью " . $data_tom_night["Temperature"] . ", " . $data_tom_night["Description"] . ", скорость ветра " . $data_tom_night["Windspeed"] . $data_tom_night["Emoji"];
        
        $after_tom_day =  "\n" . "Послезавтра днем " . $data_after_tom_day["Temperature"] . ", " . $data_after_tom_day["Description"] . ", скорость ветра " . $data_after_tom_day["Windspeed"] . $data_after_tom_day["Emoji"];
        
        $message = "";
        if(date("H:00:00") < '15:00:00'){ $message = $arguments . $now . $fifteen . $this_night . $tom_day . $after_tom_night . $after_tom_day; }
        else{ $message = $arguments . $now . $this_night . $tom_day . $after_tom_night . $after_tom_day; }
        
        $this->replyWithMessage(['text' => $message]);
    }
}
