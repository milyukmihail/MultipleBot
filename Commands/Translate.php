<?php

use \Dejurin\GoogleTranslateForFree;

class Translate {

    /**
     * Source language
     * @var type string
     */
    private $source = 'ru';
    
    /**
     * Target language
     * @var type string
     */
    private $target = 'pl';
    
    /**
     * Number of attempts 
     * @var type int
     */
    private $attempts = 5;
    
    /**
     *
     * @var type object
     */
    protected $tr;

    public function __construct() {
        $this->tr = new GoogleTranslateForFree();
    }

    /**
     * Translate text
     * @param type $text string
     * @return type array
     */
    public function Translate($text) {
        $emoji = $this->SourceNTarget($text);

        return [$emoji, $this->tr->translate($this->source, $this->target, $text, $this->attempts)];
    }

    /**
     * Set source and target
     * @param type $text string
     * @return string emoji
     */
    public function SourceNTarget($text) {

        $alphabet = ['а', 'б', 'в', 'г', 'д', 'е', 'ё', 'ж', 'з', 'и', 'й', 'к', 'л', 'м', 'н', 'о', 'п', 'р', 'с', 'т', 'у', 'ф', 'х', 'ц', 'ч', 'ш', 'щ', 'ъ', 'ы', 'ь', 'э', 'ю', 'я'];
        $arr = $this->StrSplitUnicode(mb_strtolower($text));
        $i = 0;
        foreach ($alphabet as $list) {
            if (($arr[0] === $list) || ($arr[1] === $list)) {
                $i++;
            }
        }
        if ($i === 2) {
            $this->source = 'ru';
            $this->target = 'pl';
            return "\xf0\x9f\x87\xb5\xf0\x9f\x87\xb1";
        } else {
            $this->source = 'pl';
            $this->target = 'ru';
            return "\xF0\x9F\x87\xB7\xF0\x9F\x87\xBA";
        }
    }

    /**
     * 
     * @param type $text
     * @param type $l
     * @return type array
     */
    public function StrSplitUnicode($text, $l = 0) {
        if ($l > 0) {
            $ret = array();
            $len = mb_strlen($text, "UTF-8");
            for ($i = 0; $i < $len; $i += $l) {
                $ret[] = mb_substr($text, $i, $l, "UTF-8");
            }
            return $ret;
        }
        return preg_split("//u", $text, -1, PREG_SPLIT_NO_EMPTY);
    }

}
