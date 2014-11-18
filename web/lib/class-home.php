<?php
use \Httpful\Request;

class Home extends Item {
    public $works, $creators;

    const PAINTING = 3305213;
    const PAINTER = 1028181;

    function __construct() {
        $pInstanceof = substr(Properties::INSTANCE_OF, 1);
        $pOccupation = substr(Properties::OCCUPATION, 1);
        $workQuery = sprintf("CLAIM[%s:%s]", $pInstanceof, self::PAINTING);
        $creatorsQuery = sprintf("CLAIM[%s:%s]", $pOccupation, self::PAINTER);

        $this->works = $this->getQuery($workQuery, 50);
        $this->creators = $this->getQuery($creatorsQuery, 50);
    }
}