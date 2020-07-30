<?php

namespace Telegram\Bot\Commands;

include 'Commands\Currencies.php';
include 'Commands\CurrenciesNBRB.php';

use Telegram\Bot\Actions;
use Telegram\Bot\Commands\Command;

class CurrenciesCommand extends Command {

    /**
     * @var string Command Name
     */
    protected $name = "currencies";

    /**
     * @var string Command Description
     */
    protected $description = "Введите команду, что бы начать";
    
    /**
     *
     * @var type array
     */
    public $valuta = ['EUR' => 0, 'PLN' => 1, 'USD' => 2];
    
    /**
     *
     * @var type array
     */
    public $valutaNBRB = ['EUR' => 5, 'PLN' => 6, 'USD' => 4];
    
    /**
     * @inheritdoc
     */
    public function handle($arguments) {
        
        $this->replyWithChatAction(['action' => Actions::TYPING]);

        $commands = $this->getTelegram()->getCommands();


        $response = '';
        foreach ($commands as $name => $command) {
            $response .= sprintf('/%s - %s' . PHP_EOL, $name, $command->getDescription());
        }

        $currencies = new \Currencies();
        $fullUSD = $currencies->getFullString($this->valuta['USD']);
        $fullPLN = $currencies->getFullString($this->valuta['PLN']);
        $fullEUR = $currencies->getFullString($this->valuta['EUR']);
        
        $message = "Белагропромбанк: \n" . $fullUSD . "\n" . $fullPLN . "\n" . $fullEUR . "\n";

        $currenciesNBRB = new \CurrenciesNBRB();
        $fullUSD_NBRB = $currenciesNBRB->getFullString($this->valutaNBRB['USD']);
        $fullPLN_NBRB = $currenciesNBRB->getFullString($this->valutaNBRB['PLN']);
        $fullEUR_NBRB = $currenciesNBRB->getFullString($this->valutaNBRB['EUR']);
        
        $messageNBRB = "НацБанк: \n" . $fullUSD_NBRB . "\n" . $fullPLN_NBRB . "\n" . $fullEUR_NBRB;
        
        $stringforuser = $message . $messageNBRB;
        
        $this->replyWithMessage(['text' => $stringforuser]);
    }

}
