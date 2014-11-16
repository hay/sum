<?php
use \Httpful\Request;

class Item extends Page {
    const API_ENDPOINT = "http://chantek.bykr.org/wikidata/entity?q=%s&resolveimages=1";

    public $claims, $label, $id, $description, $image, $thumb, $creator, $year;
    public $error = false;

    function __construct($qid) {
        parent::__construct();
        $url = sprintf(self::API_ENDPOINT, $qid);
        $res = Request::get($url)->send();

        if (!$res->body->response) {
            throw new Exception("No item available for this id");
        }

        $item = $res->body->response->{'Q' . $qid};

        // print_r($item);

        $this->claims = $item->claims;
        $this->label = $item->labels;
        $this->id = $qid;
        $this->description = $item->descriptions;

        $this->parseImage();
        $this->parseDate();
        $this->creator = $this->getCreator();
    }

    private function getCreator() {
        $creator = $this->getClaim(Properties::CREATOR)->values[0];
        return $creator->value_labels;
    }

    // HACK: This is really, pretty ugly
    // See < https://en.wikipedia.org/wiki/Proleptic_Gregorian_calendar >
    private function parseProlepticDate($str) {
        $date = substr($str, 1);
        return ltrim($date, '0');
    }

    private function parseDate() {
        $date = $this->getClaim(Properties::DATE)->values[0];
        $time = strtotime( $this->parseProlepticDate($date->value->time) );
        $this->year = date("Y", $time);
    }

    private function getClaim($pid, $first = true) {
        $claim = array_filter($this->claims, function($claim) use ($pid) {
            return $claim->property_id == $pid;
        });

        if (count($claim) > 0) {
            return $first ? array_pop($claim) : $claim;
        } else {
            return false;
        }
    }

    private function parseImage() {
        $image = $this->getClaim(Properties::IMAGE);

        if ($image) {
            $image = $image->values[0]->image;
            $this->image = $image->url;
            $this->thumb = $image->thumburl;
        } else {
            // TODO: placeholder image
            $this->image = false;
            $this->thumb = false;
        }
    }

    public function title() {
        $title = $this->label;

        if ($this->creator) {
            $title .= ", $this->creator";
        }

        if ($this->year) {
            $title .= ", $this->year";
        }

        return $title;
    }
}