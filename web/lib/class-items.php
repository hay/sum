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

    public static $featured = [
        5599, // Rubens
        328523, // Monet painting
        727, // Amsterdam
        160112, // Prado
        205001, // Talking Heads
        160422 // Theo van Doesburg
    ];
}