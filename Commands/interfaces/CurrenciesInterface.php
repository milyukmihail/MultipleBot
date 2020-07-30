<?php


interface CurrenciesInterface {
    
    /**
     * Alphabetic currency code
     * @param type $valuta
     */
    public function getCharCode($valuta);

    /**
     * Unit
     * @param type $valuta
     */
    public function getScale($valuta);
    
    /**
     * Rate sell
     * @param type $valuta
     */
    public function getRateSell($valuta);
    
    /**
     * String for sending
     * @param type $valuta
     */
    public function getFullString($valuta);
    
    /**
     * Info for one valuta
     * @param type $valuta
     */
    public function getInfoForValuta($valuta);

    
}
