<?php
class Work extends Item {
    function __construct($qid) {
        parent::__construct($qid);
        $this->fullurl = sprintf("%s/work/%s", $this->root, $qid);
    }
}