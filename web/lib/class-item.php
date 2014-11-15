<?php
use \Httpful\Request;

class Item extends Page {
    const API_ENDPOINT = "http://chantek.bykr.org/wikidata/entity?q=%s&resolveimages=1";

    public $claims, $label, $id, $description, $image, $thumb;
    public $error = false;

    function __construct($qid) {
        parent::__construct();
        $url = sprintf(self::API_ENDPOINT, $qid);
        $res = Request::get($url)->send();

        if (!$res->body->response) {
            throw new Exception("No item available for this id");
        }

        $item = $res->body->response->{'Q' . $qid};

        $this->claims = $item->claims;
        $this->label = $item->labels;
        $this->id = $qid;
        $this->description = $item->descriptions;

        $this->parseImage();
    }

    private function parseImage() {
        $image = array_filter($this->claims, function($claim) {
            return $claim->property_id == Properties::IMAGE;
        });

        if (count($image) > 0) {
            $image = array_pop($image)->values[0]->image;
            $this->image = $image->url;
            $this->thumb = $image->thumburl;
        } else {
            // TODO: placeholder image
            return false;
        }
    }
}