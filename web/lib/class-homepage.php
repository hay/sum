<?php
class Homepage extends Page {
    public $featured;

    function __construct() {
        parent::__construct();
        $this->featured = $this->getFeatured();
    }

    private function getFeatured() {
        $lang = $this->lang;

        return array_map(function($qid) use ($lang) {
            $item = new WikidataItem($qid, $lang);
            return $item->getItemData();
        }, Items::$featured);
    }
}