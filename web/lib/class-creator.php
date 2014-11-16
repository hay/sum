<?php
class Creator extends Item {
    public $avatar, $placeOfBirth, $placeOfDeath;

    function __construct($qid) {
        parent::__construct($qid);
        $this->parseAvatar();
        $this->placeOfBirth = $this->getClaimLabel(Properties::PLACEOFBIRTH);
        $this->placeOfDeath = $this->getClaimLabel(Properties::PLACEOFDEATH);
        $this->dateOfBirth = $this->getClaimDate(Properties::DATEOFBIRTH, "Y");
        $this->dateOfDeath = $this->getClaimDate(Properties::DATEOFDEATH, "Y");
    }

    public function parseAvatar() {
        // print_r($this);
        $this->avatar = $this->thumb;
    }
}