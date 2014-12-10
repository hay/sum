<?php
class Items {
    const PAINTING = "Q3305213";
    const FRESCO = "Q134194";
    const PAINTER = "Q1028181";

    public static $work = [
        [ Properties::INSTANCE_OF => self::PAINTING ],
        [ Properties::INSTANCE_OF => self::FRESCO ]
    ];

    public static $creator = [
        [ Properties::OCCUPATION => self::PAINTER ]
    ];
}