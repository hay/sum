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
        $works = $this->getQuery(Properties::COLLECTION, $this->id);

        if (empty($works)) {
            return [];
        } else {
            return array_map(function($work) {
                return new Work($work, 300);
            }, $works);
        }
    }
}