<?php
use \Httpful\Request;

class Page {
    public $root, $lang, $title, $fullurl;
    private $langcodes;

    const WIKIDATA_QUERY_ENDPOINT = "%s/wikidata/query?q=%s&lang=%s&from=0&size=%s";
    const DEFAULT_THUMB = "//upload.wikimedia.org/wikipedia/commons/thumb/3/34/Art-portrait-collage_2.jpg/660px-Art-portrait-collage_2.jpg";

    function __construct() {
        $this->root = ROOT;
        $this->title = "The Sum of All Paintings";
        $this->fullurl = $this->root;
        $this->thumb = self::DEFAULT_THUMB;
        $this->langcodes = json_decode(file_get_contents(ABSPATH . '/data/langcodes.json'));
        $this->lang = $this->getLanguage();
    }

    private function getLanguage() {
        if (empty($_GET['lang'])) {
            return DEFAULT_LANGUAGE;
        }

        $lang = strtolower($_GET['lang']);

        if (array_key_exists($lang, $this->langcodes)) {
            return $lang;
        } else {
            return DEFAULT_LANGUAGE;
        }
    }

    protected function getQuery($query, $size = 4) {
        $url = sprintf(self::WIKIDATA_QUERY_ENDPOINT,
            API_ENDPOINT,
            urlencode($query),
            $this->lang,
            $size
        );

        $req = Request::get($url)->send();

        return isset($req->body->response) ? $req->body->response : [];
    }
}