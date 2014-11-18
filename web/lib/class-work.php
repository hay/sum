<?php
class Work extends Item {
    function __construct($qid, $thumbsize) {
        parent::__construct($qid, $thumbsize);
        $this->fullurl = sprintf("%s/work/%s", $this->root, $qid);
    }
}