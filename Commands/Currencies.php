<?php

include_once 'interfaces/CurrenciesInterface.php';

class Currencies implements CurrenciesInterface {
    
    /**
     *
     * @var type xml
     */
    protected $xml;
    
    public function __construct() {
        $client = new \GuzzleHttp\Client();
        
        $date = date("m/d/Y");
        
        $url = 'https://belapb.by/CashExRatesDaily.php?ondate=' . $date;
        
        $res = $client->request('GET', $url);
        
        $this->xml = new SimpleXMLElement((string) $res->getBody());
        $this->xml = json_encode($this->xml);       
        $this->xml = json_decode($this->xml);
    }
    
    /**
     * Message for sending
     * @param type $valuta int
     * @return type string
     */
    public function getFullString($valuta)
    {
        $info = $this->getInfoForValuta($valuta);
        
        return $string = $info['Emoji'] . $info['Scale'] . " " . $info['CharCode'] .
                " продажа - " . round($info['RateBuy'], 2) . " BYN, покупка - " . round($info['RateSell'], 2) . " BYN";
    }
    
    /**
     * Info for valuta
     * @param type $valuta int
     * @return type array
     */
    public function getInfoForValuta($valuta) {
        $fullInfo = [
            'CharCode' => $this->getCharCode($valuta),
            'Scale' => $this->getScale($valuta),
            'RateBuy' => $this->getRateBuy($valuta),
            'RateSell' => $this->getRateSell($valuta),
            'Emoji' => $this->getEmoji($valuta)
        ];

        return $fullInfo;
    }

    /**
     * Alphabetic currency code
     * @param type $valuta int
     * @return type string
     */
    public function getCharCode($valuta)
    {
        return $this->xml->Currency[$valuta]->CharCode;
    }
    
    /**
     * Unit
     * @param type $valuta int
     * @return type string
     */
    public function getScale($valuta)
    {
        return $this->xml->Currency[$valuta]->Scale;
    }
    
    /**
     * Rate buy
     * @param type $valuta int
     * @return type string
     */
    public function getRateBuy($valuta)  //курс покупки
    {
        return $this->xml->Currency[$valuta]->RateBuy;
    }
    
    /**
     * Rate sell
     * @param type $valuta int
     * @return type string
     */
    public function getRateSell($valuta)  //курс продажи
    {
        return $this->xml->Currency[$valuta]->RateSell;
    }

    /**
     * Code of emoji
     * @param type $valuta int
     * @return string string
     */
    public function getEmoji($valuta)
    {
        if($valuta === 0){return "\xf0\x9f\x87\xaa\xf0\x9f\x87\xba";}
        if($valuta === 1){return "\xf0\x9f\x87\xb5\xf0\x9f\x87\xb1";}
        if($valuta === 2){return "\xF0\x9F\x87\xBA\xF0\x9F\x87\xB8";}
    }
}
