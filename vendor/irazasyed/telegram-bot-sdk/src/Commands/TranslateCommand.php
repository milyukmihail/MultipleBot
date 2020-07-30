<?php

namespace Telegram\Bot\Commands;

include 'Commands\Translate.php';

use Telegram\Bot\Actions;
use Telegram\Bot\Commands\Command;

namespace Telegram\Bot\Commands;

class TranslateCommand extends Command {
    
    /**
     *
     * @var type string
     */
    protected $name = 'translate';

    /**
     *
     * @var type string
     */
    protected $description = 'Перевод';
    
    /**
     * 
     * @inheritdoc
     */
    public function handle($arguments)
    {  
        $translate = new \Translate();
        $result = $translate->Translate($arguments);
        $message = $result[0] . " " . $result[1];

        $this->replyWithMessage(['text' => $message]);       
    }
}
