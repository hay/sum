<?php
use \Httpful\Request;

class Creator extends Item {
    const WIKIDATA_QUERY_ENDPOINT = "%s/wikidata/query?q=%s&lang=%s&from=0&size=1";

    public $avatar, $placeOfBirth, $placeOfDeath, $works;

    function __construct($qid) {
        parent::__construct($qid);
        $this->fullurl = sprintf("%s/creator/%s", $this->root, $qid);
        $this->parseAvatar();
        $this->placeOfBirth = $this->getClaimLabel(Properties::PLACEOFBIRTH);
        $this->placeOfDeath = $this->getClaimLabel(Properties::PLACEOFDEATH);
        $this->dateOfBirth = $this->getClaimDate(Properties::DATEOFBIRTH, "Y");
        $this->dateOfDeath = $this->getClaimDate(Properties::DATEOFDEATH, "Y");
        $this->works = $this->getWorks();
    }

    private function getWorks(){
        $claim = sprintf("CLAIM[%s:%s]", substr(Properties::CREATOR, 1), $this->id);
        $url = sprintf(self::WIKIDATA_QUERY_ENDPOINT, API_ENDPOINT, $claim, $this->lang);
        $req = Request::get($url)->send();

        if (!$req->body->response) {
            return [];
        }

        return array_map(function($work) {
            return new Work($work);
        }, $req->body->response);
    }

    public function parseAvatar() {
        // FIMXE: For some reason Chantek doesn't return an image for Rembrandt :/
        $this->avatar = $this->thumb;
    }
}