<?php
class Creator extends Item {
    public $placeOfBirth, $placeOfDeath, $works;

    function __construct($qid) {
        parent::__construct($qid);
        $this->fullurl = sprintf("%s/creator/%s", $this->root, $qid);
        $this->placeOfBirth = $this->getClaimLabel(Properties::PLACEOFBIRTH);
        $this->placeOfDeath = $this->getClaimLabel(Properties::PLACEOFDEATH);
        $this->dateOfBirth = $this->getClaimDate(Properties::DATEOFBIRTH, "Y");
        $this->dateOfDeath = $this->getClaimDate(Properties::DATEOFDEATH, "Y");
        $this->works = $this->getWorks();
        $this->hasWorks = !empty($this->works);

        if ($this->hasWorks) {
            $this->workThumb = $this->works[0]->thumb;
        }
    }

    private function getWorks(){
        $query = sprintf("CLAIM[%s:%s] AND CLAIM[%s]",
            substr(Properties::CREATOR, 1),
            $this->id,
            substr(Properties::IMAGE, 1)
        );

        $works = $this->getQuery($query);

        if (empty($works)) {
            return [];
        } else {
            return array_map(function($work) {
                return new Work($work, 300);
            }, $works);
        }
    }
}