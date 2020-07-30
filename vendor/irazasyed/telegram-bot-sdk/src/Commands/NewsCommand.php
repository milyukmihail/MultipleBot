<?php

namespace Telegram\Bot\Commands;

include 'Commands\News.php';

use Telegram\Bot\Actions;
use Telegram\Bot\Commands\Command;


class NewsCommand extends Command{
    
    /**
     *
     * @var type 
     */
    protected $name = 'news';

    protected $description = 'Новости по ключевому слову';
    
    public function handle($arguments)
    {  
        $news = new \News($arguments);
        
        $links = $news->getPartNews('div.results-header', 'a', 'href');
        
        foreach($links as $link)
        $this->replyWithMessage(['text' => $link]);
    }
}
