<?php
use \Httpful\Request;

class WikidataSearch {
    const WIKIDATA_SEARCH_ENDPOINT = "%s/wikidata/search?q=%s&lang=%s";

    private $query, $lang, $result;

    function __construct($query, $lang) {
        $this->query = $query;
        $this->lang = $lang;
        $this->result = $this->getResult();
    }

    public function getResultData() {
        return $this->result;
    }

    private function getResult() {
        $url = sprintf(self::WIKIDATA_SEARCH_ENDPOINT,
            API_ENDPOINT,
            urlencode($this->query),
            $this->lang
        );

        $req = Request::get($url)->send();

        return isset($req->body->response) ? $req->body->response : [];
    }
}