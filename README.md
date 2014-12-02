Sum
===
[The sum of all paintings](https://www.wikidata.org/wiki/Wikidata:WikiProject_sum_of_all_paintings), powered by [Wikidata](http://www.wikidata.org).

## Installing
To install the dependencies for this project you need [bower](http://bower.io) (for frontend assets) and [Composer](http://getcomposer.org) (for PHP libraries).

First copy `config-sample.php` in the `web` directory to `config.php` and change the values. You need a [Chantek](http://github.com/hay/chantek) server for the API calls, or use the default value (note that the current setting is not a production server).

Then, in the root of the project, install the dependencies

    bower install
    composer install

You should be able to run the application in `web/` now.

Note that you either need `mod_rewrite` (for Apache) or some other redirection magic to get pretty urls.

## Credits
* Written by [Hay Kranen](http://github.com/hay)

With contributions by:
* [Tisza Gergö](https://github.com/tgr)