<?php
use \Httpful\Request;

class Home extends Item {
    public $works, $creators;

    const PAINTING = 3305213;
    const PAINTER = 1028181;

    function __construct() {
        $this->works = $this->getQuery(Properties::INSTANCE_OF, self::PAINTING, 50);
        $this->creators = $this->getQuery(Properties::OCCUPATION, self::PAINTER, 50);
    }
}