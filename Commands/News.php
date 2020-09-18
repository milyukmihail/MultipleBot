<?php

include 'vendor/simplehtmldom/simple_html_dom.php';

class News {
    
    /**
     * Number of news sent
     * @var type int
     */
    private $count_news = 3;
    
    /**
     *
     * @var type html page
     */
    private $html;
    
    /**
     * 
     * @param type $arguments string
     */
    public function __construct($arguments) {
        
        $this->html = file_get_html('https://news.tut.by/search/?sort=relevance&str=' . $arguments);        
    }
    
    /**
     * Get news link
     * @param type $block string(tag)
     * @param type $tag string(tag)
     * @param type $takeout string
     * @return type string link
     */
    public function getPartNews($block, $tag, $takeout) {
        $data = [];
        foreach ($this->html->find($block) as $element) {
            foreach ($element->find($tag) as $link) {
                if ($i < $this->count_news) {
                    $data []= $link->$takeout;
                    $i++;
                }
            }
        }
        return $data;
    }
}
