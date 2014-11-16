<?php
use \Httpful\Request;

class Item extends Page {
    const WIKIDATA_ENDPOINT = "%s/wikidata/entity?q=%s&resolveimages=1&imagewidth=2000&imageheight=2000&lang=%s";
    const WIKIPEDIA_ENDPOINT = "%s/wikipedia/define?q=%s&lang=%s";

    private $item;

    public $claims, $label, $id, $description, $image, $thumb, $creator, $year;
    public $longdescription;
    public $error = false;

    function __construct($qid) {
        parent::__construct();
        $wikidataEndpoint = sprintf(self::WIKIDATA_ENDPOINT, API_ENDPOINT, $qid, $this->lang);
        $url = sprintf($wikidataEndpoint, $qid);
        $res = Request::get($url)->send();

        if (!$res->body->response) {
            throw new Exception("No item available for this id");
        }

        $item = $res->body->response->{'Q' . $qid};

        $this->item = $item;
        $this->claims = $item->claims;
        $this->label = isset($item->labels) ? $item->labels : false;
        $this->description = isset($item->descriptions) ? $item->descriptions : false;
        $this->id = $qid;

        $this->parseImage();
        $this->parseDate();
        $this->parseLongDescription();
        $this->creator = $this->getClaimLabel(Properties::CREATOR);
        $this->country = $this->getClaimLabel(Properties::COUNTRY);
        $this->instanceOf = $this->getClaimLabel(Properties::INSTANCE_OF);
        $this->movement = $this->getClaimLabel(Properties::MOVEMENT);
        $this->genre = $this->getClaimLabel(Properties::GENRE);
        $this->depicts = $this->getClaimLabel(Properties::DEPICTS);
        $this->materialsUsed = $this->getClaimLabel(Properties::MATERIALSUSED);
        $this->collection = $this->getClaimLabel(Properties::COLLECTION);
        $this->inventoryNr = $this->getClaimLabel(Properties::INVENTORYNR);
        $this->locatedIn = $this->getClaimLabel(Properties::LOCATEDIN);
        $this->iconclass = $this->getClaimLabel(Properties::ICONCLASS);
    }

    private function getClaimLabel($pid) {
        $claim = $this->getClaim($pid);
        if (!$claim) return;

        $labels = array_map(function($value) {
            if (isset($value->value_labels)) {
                return $value->value_labels;
            }

            if (isset($value->value)) {
                return $value->value;
            }

            return false;
        }, $claim->values);

        // Remove empty labels
        $labels = array_filter($labels);

        return implode(", ", $labels);
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

    public function museum() {
        if ($this->collection == $this->locatedIn) {
            return $this->collection;
        } else {
            return false;
        }
    }

    public function parseLongDescription() {
        if (!isset($this->item->sitelinks)) {
            $this->longdescription = false;
        }

        $title = urlencode($this->item->sitelinks->{$this->lang}->title);

        $wikipediaEndpoint = sprintf(self::WIKIPEDIA_ENDPOINT, API_ENDPOINT, $title, $this->lang);

        $req = Request::get($wikipediaEndpoint)->send();

        if (isset($req->body->response->extract)) {
            $this->longdescription = $req->body->response->extract;
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