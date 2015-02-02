<?php
    define('PATH', str_replace("/index.php", "", $_SERVER['PHP_SELF']));
    define('ROOT', sprintf(
        "//%s/%s/",
        $_SERVER['HTTP_HOST'],
        str_replace("/index.php", "", $_SERVER['PHP_SELF'])
    ));
    define('API_ENDPOINT', 'http://chantek.bykr.org');
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
    }