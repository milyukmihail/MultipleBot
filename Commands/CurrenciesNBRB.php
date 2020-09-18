<?php

include_once 'Currencies.php';

class CurrenciesNBRB extends Currencies{
    
    /**
     *
     * @var type object
     */
    private $object;
    
    public function __construct() {
        $client = new \GuzzleHttp\Client();

        $url = 'https://www.nbrb.by/api/exrates/rates?periodicity=0';
        
        $res = $client->request('GET', $url);
        
        $this->object = json_decode($res->getBody());
    }
    
    /**
     * Alphabetic currency code
     * @param type $valuta int
     * @return type string
     */
    public function getCharCode($valuta) 
    {
        return $this->object[$valuta]->Cur_Abbreviation;
    }
    
    /**
     * Unit
     * @param type $valuta int
     * @return type string
     */
    public function getScale($valuta)
    {
        return $this->object[$valuta]->Cur_Scale;
    }
    
    /**
     * Rate sell
     * @param type $valuta int
     * @return type string
     */
    public function getRateSell($valuta)
    {
        return $this->object[$valuta]->Cur_OfficialRate;
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
                " курс - " . $info['Rate'] . " BYN";
    }
    
    /**
     * Info for valuta
     * @param type $valuta int
     * @return type string
     */
    public function getInfoForValuta($valuta)
    {
        $fullInfo = [
            'Scale' => $this->getScale($valuta),
            'CharCode' => $this->getCharCode($valuta),
            'Rate' => round($this->getRateSell($valuta), 2),
            'Emoji' => $this->getEmoji($valuta)
        ];

        return $fullInfo;
    }
    
    /**
     * Emoji
     * @param type $valuta int
     * @return string
     */
    public function getEmoji($valuta)
    {
        if($valuta === 5){return "\xf0\x9f\x87\xaa\xf0\x9f\x87\xba";}
        if($valuta === 6){return "\xf0\x9f\x87\xb5\xf0\x9f\x87\xb1";}
        if($valuta === 4){return "\xF0\x9F\x87\xBA\xF0\x9F\x87\xB8";}
    }

}
