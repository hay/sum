<?php
    define('ROOT', sprintf(
        "//%s/%s/",
        $_SERVER['HTTP_HOST'],
        str_replace("/index.php", "", $_SERVER['PHP_SELF'])
    ));
    define('API_ENDPOINT', 'http://chantek.bykr.org');
    define('DEBUG', false);