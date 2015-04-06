<?php
    define('PATH', str_replace("/index.php", "", $_SERVER['PHP_SELF']));
    define('ROOT', sprintf(
        "//%s/%s/",
        $_SERVER['HTTP_HOST'],
        str_replace("/index.php", "", $_SERVER['PHP_SELF'])
    ));
    define('API_ENDPOINT', 'http://api.haykranen.nl');
    define('DEFAULT_LANGUAGE', 'en');
    define('DEBUG', false);

    class Config {
        public static $primaryLanguages = [
          "en",
          "ar",
          "ca",
          "ceb",
          "da",
          "de",
          "es",
          "fr",
          "hu",
          "it",
          "ja",
          "nl",
          "no",
          "pl",
          "pt",
          "ru",
          "sv",
          "vi",
          "war",
          "zh"
        ];


        public static $featuredContent = [
            [
                "id" => 5599,
                "label" => "Peter Paul Rubens",
                "image" => "http://commons.wikimedia.org/wiki/Special:Redirect/file/Rubens%20Self-portrait%201623.jpg?width=300"
            ],
            [
                "id" => 328523,
                "label" => "Impression, Sunrise",
                "image" => "http://commons.wikimedia.org/wiki/Special:Redirect/file/Monet%20-%20Impression,%20Sunrise.jpg?width=300"
            ],
            [
                "id" => 7378,
                "label" => "Elephant",
                "image" => "http://commons.wikimedia.org/wiki/Special:Redirect/file/African%20Bush%20Elephant.jpg?width=300"
            ],
            [
                "id" => 160112,
                "label" => "Museo del Prado",
                "image" => "http://commons.wikimedia.org/wiki/Special:Redirect/file/Museo%20del%20Prado.jpg?width=300"
            ],
            [
                "id" => 202765,
                "label" => "Kate Winslet",
                "image" => "http://commons.wikimedia.org/wiki/Special:Redirect/file/KateWinsletByAndreaRaffin2011.jpg?width=300"
            ],
            [
                "id" => 6663,
                "label" => "Hamburger",
                "image" => "http://commons.wikimedia.org/wiki/Special:Redirect/file/NCI%20Visuals%20Food%20Hamburger.jpg?width=300"
            ]
        ];
    }