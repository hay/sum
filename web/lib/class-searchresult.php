<?php
class SearchResult extends Page {
    public $searchresults;

    function __construct($q) {
        parent::__construct();
        $searchresults = new WikidataSearch($q, $this->lang);
        $this->searchresults = $searchresults->getResultData();
    }
}