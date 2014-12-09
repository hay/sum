<?php
use \Httpful\Request;

class Item extends Page  {
    const WIKIPEDIA_ENDPOINT = "%s/wikipedia/article?q=%s&lang=%s";
    const WIKIDATA_ENDPOINT = "%s/wikidata/entity?q=%s&lang=%s";

    private $qid;

    function __construct($qid) {
        parent::__construct();
        $this->fullurl = sprintf("%s/%s", $this->root, $qid);
        $this->qid = $qid;
        $this->item = $this->getItem();

        if (property_exists($this->item->sitelinks, $this->lang)) {
            $this->article = $this->getArticle();
        }
    }

    public function getPageType() {
        return "article";
    }

    private function getItem() {
        $url = sprintf(self::WIKIDATA_ENDPOINT, API_ENDPOINT, $this->qid, $this->lang);
        $res = Request::get($url)->send();

        if (!$res->body->response) {
            throw new Exception("This item does not exist", 404);
        }

        return reset($res->body->response);
    }

    private function getArticle() {
        $title = $this->item->sitelinks->{$this->lang}->title;

        $url = sprintf(self::WIKIPEDIA_ENDPOINT, API_ENDPOINT, urlencode($title), $this->lang);
        $res = Request::get($url)->send();

        if (!$res->body->response) {
            throw new Exception("No article available for this id");
        }

        $article = $res->body->response;

        $article->images = array_filter($article->images, function($img) {
            $path = pathinfo($img->title);
            $ext = strtolower($path['extension']);
            return $ext == "jpg" || $ext == "png" || $ext == "gif";
        });

        $article->images = array_values($article->images);
        $article->firstimage = !empty($article->images) ? $article->images[0] : false;

        return $article;
    }
}