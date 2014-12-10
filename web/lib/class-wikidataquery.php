<?php
use \Httpful\Request;

class WikidataQuery {
    const WIKIDATA_QUERY_ENDPOINT = "%s/wikidata/query?q=%s&lang=%s&from=0&size=%s";

    private $query, $lang, $result;

    function __construct($query, $lang) {
        $this->query = $query;
        $this->lang = $lang;
        $this->result = array_map(function($qid) use ($lang) {
            $item = new WikidataItem($qid, $lang);
            return $item->getItemData();
        }, $this->getResult());
    }

    public function getResultData() {
        return $this->result;
    }

    private function getResult($size = 4) {
        $url = sprintf(self::WIKIDATA_QUERY_ENDPOINT,
            API_ENDPOINT,
            urlencode($this->query),
            $this->lang,
            $size
        );

        $req = Request::get($url)->send();

        return isset($req->body->response) ? $req->body->response : [];
    }
}