<?php
class Page {
    public $root, $lang, $title, $fullurl;

    const DEFAULT_THUMB = "//upload.wikimedia.org/wikipedia/commons/thumb/3/34/Art-portrait-collage_2.jpg/660px-Art-portrait-collage_2.jpg";

    function __construct() {
        $this->root = ROOT;
        $this->title = "The Sum of All Paintings";
        $this->fullurl = $this->root;
        $this->thumb = self::DEFAULT_THUMB;
         // We should probably make this an url parameter or something
        $this->lang = DEFAULT_LANGUAGE;
    }
}