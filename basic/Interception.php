<?php



class Interception {
    
    /**
     * @var string
     */
    public $messagestring;
    
    /**
     * Checking slashes
     * @return boolean
     */
    public function slashCheck()
    {
        $position = strval(mb_stripos($this->messagestring, '/'));
        if($position === '0') // Иногда не корректно работает из-за ===
        {
            return true;
        }
        return false;
    }
    
    /**
     * Sending an interactive message
     * @param type $chatid
     * @param type $telegram
     */
    public function sendInteractiveMessage($chatid, $telegram)
    {   $slashcommand = explode(" ", $this->messagestring);
    
        if($slashcommand[0] === '/weather')
        {$interactivemsg = "Отлично! Теперь отправьте мне населенный пункт.";
            $this->sendMessage($chatid, $interactivemsg, $telegram);}
        if($slashcommand[0] === '/news')
        {$interactivemsg = "Отлично! Теперь отправьте мне ключевое слово для поиска.";
            $this->sendMessage($chatid, $interactivemsg, $telegram);}
        if($slashcommand[0] === '/translate')
        {$interactivemsg = "Отлично! Теперь отправьте мне текст для перевода.";
            $this->sendMessage($chatid, $interactivemsg, $telegram);}
    }
    
    /**
     * Sending message
     * @param type $chatid int
     * @param type $interactivemsg string
     * @param type $telegram object
     */
    public function sendMessage($chatid, $interactivemsg, $telegram) {
        $telegram->sendMessage([
            'chat_id' => $chatid,
            'text' => $interactivemsg
        ]);
    }

}
