<?php
class Items {
    const PAINTING = "Q3305213";
    const FRESCO = "Q134194";
    const PAINTER = "Q1028181";
    const ACTOR = "Q33999";
    const FILM_DIRECTOR = "Q2526255";
    const HUMAN = "Q5";
    const WRITER = "Q36180";

    public static $work = [
        [ Properties::INSTANCE_OF => self::PAINTING ],
        [ Properties::INSTANCE_OF => self::FRESCO ]
    ];

    public static $person = [
        [ Properties::INSTANCE_OF => self::HUMAN ]
    ];

    public static $creator = [
        [ Properties::OCCUPATION => self::PAINTER ],
        [ Properties::OCCUPATION => self::ACTOR],
        [ Properties::OCCUPATION => self::FILM_DIRECTOR ],
        [ Properties::OCCUPATION => self::WRITER ]
    ];

    public static $featured = [
        5599,
        328523,
        7378,
        160112,
        202765,
        6663
    ];
}