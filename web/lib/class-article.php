<?php
use \Httpful\Request;

class Article extends Page  {
    const WIKIPEDIA_ENDPOINT = "%s/wikipedia/article?q=%s&lang=%s";

    function __construct($qid) {
        parent::__construct();
        $this->fullurl = sprintf("%s/article/%s", $this->root, $qid);

        $url = sprintf(self::WIKIPEDIA_ENDPOINT, API_ENDPOINT, urlencode($qid), $this->lang);
        $res = Request::get($url)->send();

        if (!$res->body->response) {
            throw new Exception("No article available for this id");
        }

        $item = $res->body->response;

        $this->images = array_filter($item->images, function($img) {
            $path = pathinfo($img->title);
            $ext = strtolower($path['extension']);
            return $ext == "jpg" || $ext == "png" || $ext == "gif";
        });

        $this->images = array_values($this->images);

        $this->firstimage = $this->images[0];

        $this->text = $item->text;

        $this->thumbnail = $item->thumbnail;
    }
}