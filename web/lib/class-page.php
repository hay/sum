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

    protected function getQuery($query, $size = 4) {
        $url = sprintf(self::WIKIDATA_QUERY_ENDPOINT,
            API_ENDPOINT,
            urlencode($query),
            $this->lang,
            $size
        );

        $req = Request::get($url)->send();

        return $req->body->response ? $req->body->response : [];
    }
}