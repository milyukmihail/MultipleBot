<?php

namespace Telegram\Bot\Commands;

use Telegram\Bot\Actions;
use Telegram\Bot\Commands\Command;

class StartCommand extends Command
{
    /**
     * @var string Command Name
     */
    private $name = "start";

    /**
     * @var string Command Description
     */
    private $description = "Введите команду, что бы начать";

    /**
     * @inheritdoc
     */
    public function handle($arguments)
    {

        $this->replyWithMessage(['text' => 'Здравствуйте! Добро пожаловать в наш бот, вот наши доступные команды:']);


        $this->replyWithChatAction(['action' => Actions::TYPING]);

        $commands = $this->getTelegram()->getCommands();

        $response = '';
        foreach ($commands as $name => $command) {
            $response .= sprintf('/%s - %s' . PHP_EOL, $name, $command->getDescription());
        }

        $this->replyWithMessage(['text' => $response]);
    }
}
