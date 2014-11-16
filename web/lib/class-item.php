<?php
use \Httpful\Request;

class Item extends Page {
    const API_ENDPOINT = "http://chantek.bykr.org/wikidata/entity?q=%s&resolveimages=1&imagewidth=2000&imageheight=2000";

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

        $this->claims = $item->claims;
        $this->label = isset($item->labels) ? $item->labels : false;
        $this->description = isset($item->descriptions) ? $item->descriptions : false;
        $this->id = $qid;

        $this->parseImage();
        $this->parseDate();
        $this->creator = $this->getCreator();
    }

    private function getCreator() {
        $creator = $this->getClaim(Properties::CREATOR);
        if (!$creator) return;

        return $creator->values[0]->value_labels;
    }

    // HACK: This is really, pretty ugly
    // See < https://en.wikipedia.org/wiki/Proleptic_Gregorian_calendar >
    private function parseProlepticDate($str) {
        $date = substr($str, 1);
        return ltrim($date, '0');
    }

    private function parseDate() {
        $date = $this->getClaim(Properties::DATE);

        if (!$date) return;

        $time = strtotime( $this->parseProlepticDate($date->values[0]->value->time) );
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

        if ($image && $image->values[0] && isset($image->values[0]->image)) {
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

        if ($this->label) {
            $title .= " by ";
        }

        if ($this->creator) {
            $title .= $this->creator;
        }

        if ($this->year) {
            $title .= " ($this->year)";
        }

        return $title;
    }
}