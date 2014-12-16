<?php
use \Httpful\Request;
use Underscore\Types\Arrays;

class WikidataItem {
    const WIKIDATA_ENDPOINT = "%s/wikidata/entity?q=%s&lang=%s";

    private $qid, $item, $lang;

    function __construct($qid, $lang) {
        $this->qid = $qid;
        $this->lang = $lang;
        $this->item = $this->getItem();
    }

    public function addValues($properties) {
        foreach ($properties as $key => $pid) {
            $this->item->{$key} = $this->getClaimValues($pid);
        }
    }

    private function getClaimValues($pid) {
        $claim = $this->getClaim($pid);
        if (!$claim) return false;

        $values = array_map(function($value) {
            if ($value->datatype == "globe-coordinate") {
                return $value->value;
            }

            if ($value->datatype == "time") {
                $time = $this->parseProlepticDate($value->value->time);
                return date_parse($time);
            }

            if ($value->datatype == "wikibase-item") {
                return [
                    "label" => $value->value_labels,
                    "id" => $value->value
                ];
            }

            if ($value->datatype == "string") {
                return $value->value;
            }

            return false;
        }, $claim->values);

        // Remove empty labels
        return array_filter($values);
    }

    // HACK: This is really, pretty ugly
    // See < https://en.wikipedia.org/wiki/Proleptic_Gregorian_calendar >
    private function parseProlepticDate($str) {
        $date = substr($str, 1);
        return ltrim($date, '0');
    }

    public function getItemData() {
        return $this->item;
    }

    public function getClaim($pid) {
        foreach ($this->item->claims as $claim) {
            if ($claim->property_id == $pid) {
                return $claim;
            }
        }

        return false;
    }

    public function hasClaimWhere($queries) {
        foreach ($queries as $query) {
            foreach ($query as $propid => $itemid) {
                $prop = $this->getClaim($propid);

                if (!$prop) continue;

                foreach ($prop->values as $value) {
                    if ($value->value == $itemid) {
                        return true;
                    }
                }
            }
        }

        return false;
    }

    private function getItem() {
        $url = sprintf(self::WIKIDATA_ENDPOINT, API_ENDPOINT, $this->qid, $this->lang);
        $res = Request::get($url)->send();

        if ($res->code == 500) {
            throw new Exception("Could not connect to API", 500);
        }

        if (!$res->body->response) {
            throw new Exception("This item does not exist", 404);
        }

        return reset($res->body->response);
    }
}