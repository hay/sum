<?php
use \Httpful\Request;

class Page {
    public $root, $lang, $title, $fullurl;

    const WIKIDATA_QUERY_ENDPOINT = "%s/wikidata/query?q=%s&lang=%s&from=0&size=%s";
    const DEFAULT_THUMB = "//upload.wikimedia.org/wikipedia/commons/thumb/3/34/Art-portrait-collage_2.jpg/660px-Art-portrait-collage_2.jpg";

    function __construct() {
        $this->root = ROOT;
        $this->title = "The Sum of All Paintings";
        $this->fullurl = $this->root;
        $this->thumb = self::DEFAULT_THUMB;
         // We should probably make this an url parameter or something
        $this->lang = DEFAULT_LANGUAGE;
    }

    protected function getQuery($has, $item = false, $size = 4) {
        $has = substr($has, 1);

        if ($item) {
            $claim = sprintf("CLAIM[%s:%s]", $has, $item);
        } else {
            $claim = sprintf("CLAIM[%s]", $has);
        }

        $url = sprintf(self::WIKIDATA_QUERY_ENDPOINT, API_ENDPOINT, $claim, $this->lang, $size);
        $req = Request::get($url)->send();

        return $req->body->response ? $req->body->response : [];
    }
}