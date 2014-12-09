<?php
use \Httpful\Request;

class Article extends Page  {
    const WIKIPEDIA_ENDPOINT = "%s/wikipedia/article?q=%s&lang=%s";
    const WIKIDATA_ENDPOINT = "%s/wikidata/entity?q=%s&lang=%s";

    function __construct($qid) {
        parent::__construct();
        $this->fullurl = sprintf("%s/article/%s", $this->root, $qid);

        // First resolve the id to Wikipedia articles
        $url = sprintf(self::WIKIDATA_ENDPOINT, API_ENDPOINT, $qid, $this->lang);
        $res = Request::get($url)->send();

        if (!$res->body->response) {
            throw new Exception("No article available for this id");
        }

        $response = reset($res->body->response);

        if (!property_exists($response->sitelinks, $this->lang)) {
            throw new Exception("No article available in your language for this id");
        }

        if (property_exists($response, "labels")) {
            $this->label = $response->labels;
        }

        if (property_exists($response, "descriptions")) {
            $this->description = $response->descriptions;
        }

        $title = $response->sitelinks->{$this->lang}->title;

        $url = sprintf(self::WIKIPEDIA_ENDPOINT, API_ENDPOINT, urlencode($title), $this->lang);
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
        $this->firstimage = !empty($this->images) ? $this->images[0] : false;
        $this->text = $item->text;
        $this->thumbnail = $item->thumbnail;
    }
}