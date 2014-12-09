<?php
use \Httpful\Request;

class Item extends Page  {
    private $qid;

    function __construct($qid) {
        parent::__construct();
        $this->fullurl = sprintf("%s/%s", $this->root, $qid);
        $this->qid = $qid;
        $wditem = new WikidataItem($this->qid, $this->lang);
        $this->item = $wditem->getItemData();

        if (property_exists($this->item->sitelinks, $this->lang)) {
            $title = $this->item->sitelinks->{$this->lang}->title;
            $article = new WikipediaArticle($title, $this->lang);
            $this->article = $article->getArticleData();
        }
    }

    public function getPageType() {
        return "article";
    }
}