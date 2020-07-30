<?php

include 'vendor/autoload.php';

include 'basic/Interception.php';
include 'basic/Storage.php';

use Telegram\Bot\Api;

$telegram = new Api('TOKEN');

$interception = new Interception($telegram);

$storage = new Storage();

$commands = [
           \Telegram\Bot\Commands\HelpCommand::class,
           \Telegram\Bot\Commands\StartCommand::class,
           \Telegram\Bot\Commands\CurrenciesCommand::class,
           \Telegram\Bot\Commands\WeatherCommand::class,
           \Telegram\Bot\Commands\NewsCommand::class,
           \Telegram\Bot\Commands\TranslateCommand::class
       ];

$telegram->addCommands($commands);

$result = $telegram -> getWebhookUpdates();

$interception->messagestring = $result->getMessage()->getText(); //The current message from the user is passed to the property

$storage->chatid = $result->getMessage()->getChat()->getId();

if ($interception->slashCheck()) { //If there's /
    
    $interception->sendInteractiveMessage($storage->chatid, $telegram);
    
    $commandname = trim($interception->messagestring, '/');      //Push the message into the redis
    
    
    if(mb_stripos($interception->messagestring, 'start') || mb_strpos($interception->messagestring, 'help') || mb_strpos($interception->messagestring, 'currencies'))
    {
        $commandsHandler = $telegram->commandsHandler(true);
        
        $telegram->getCommandBus()->execute($commandname, $arguments);
        $interception->messagestring = '0';
    }
    $storage->pushMessagestring($interception->messagestring);
    
} else {                          // if not /
    $arguments = $interception->messagestring;

    $interception->messagestring = $storage->getLastMessage();  // get the last massage from radis
    $storage->pushMessagestring($arguments);

    if ($interception->slashCheck()) {  // If the last message contains /, then we transfer control to the controller by name
        $commandname = trim($interception->messagestring, '/');
        
        $commandsHandler = $telegram->commandsHandler(true);
        
        $telegram->getCommandBus()->execute($commandname, $arguments, $commandsHandler);
    }
}
