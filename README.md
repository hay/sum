Sum
===
The sum of all paintings, powered by Wikidata

## Installing
To install the dependencies for this project you need [bower](http://bower.io) (for frontend assets) and [Composer](http://getcomposer.org) (for PHP libraries).

First copy `config-sample.php` in the `web` directory to `config.php` and change the values. You need a [Chantek](http://github.com/hay/chantek) server for the API calls, or use the default value (note that the current setting is not a production server).

Then, in the root of the project, install the dependencies

    bower install
    composer install

You should be able to run the application in `web/` now.

Note that you either need `mod_rewrite` (for Apache) or some redirection magic for nginx to get the pretty urls.