<?php
class Homepage extends Page {
    public $featured;

    function __construct() {
        parent::__construct();
        $this->featured = $this->getFeatured();
    }

    private function getFeatured() {
        return Config::$featuredContent;
    }
}