<?php
use \Httpful\Request;

class Page {
    public $root, $lang, $title, $fullurl;
    private $langcodes;

    function __construct() {
        $this->root = ROOT;
        $this->title = "The Sum of All Knowledge";
        $this->fullurl = $this->root;
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
}