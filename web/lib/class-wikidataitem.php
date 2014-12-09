<?php
use \Httpful\Request;

class WikidataItem {
    const WIKIDATA_ENDPOINT = "%s/wikidata/entity?q=%s&lang=%s";

    private $qid, $item, $lang;

    function __construct($qid, $lang) {
        $this->qid = $qid;
        $this->lang = $lang;
        $this->item = $this->getItem();
    }

    public function getItemData() {
        return $this->item;
    }

    private function getItem() {
        $url = sprintf(self::WIKIDATA_ENDPOINT, API_ENDPOINT, $this->qid, $this->lang);
        $res = Request::get($url)->send();

        if (!$res->body->response) {
            throw new Exception("This item does not exist", 404);
        }

        return reset($res->body->response);
    }
}