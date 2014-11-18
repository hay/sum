<?php
class Institution extends Item {
    public $works;

    function __construct($qid) {
        parent::__construct($qid);
        $this->fullurl = sprintf("%s/institution/%s", $this->root, $qid);

        $this->works = $this->getWorks();
        $this->hasWorks = !empty($this->works);

        if ($this->hasWorks) {
            $this->workThumb = $this->works[0]->thumb;
        }
    }

    private function getWorks(){
        $query = sprintf("CLAIM[%s:%s] OR CLAIM[%s:%s] AND CLAIM[%s]",
            substr(Properties::COLLECTION, 1), $this->id,
            substr(Properties::LOCATEDIN, 1), $this->id,
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