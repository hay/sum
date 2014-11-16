<?php
class Page {
    public $root, $lang;

    function __construct() {
        $this->root = ROOT;
         // We should probably make this an url parameter or something
        $this->lang = DEFAULT_LANGUAGE;
    }
}