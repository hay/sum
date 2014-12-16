<?php
class SearchResult extends Page {
    public $searchresults, $q;

    function __construct($q) {
        parent::__construct();
        $this->q = $q;
        $searchresults = new WikidataSearch($q, $this->lang);
        $this->isSearch = true;
        $this->searchresults = $searchresults->getResultData();
    }
}