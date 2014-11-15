<?php
    define('ABSPATH', dirname(__FILE__));
    define('ROOT', sprintf(
        "//%s/%s/",
        $_SERVER['HTTP_HOST'],
        str_replace("/index.php", "", $_SERVER['PHP_SELF'])
    ));