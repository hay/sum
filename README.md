The Sum of All Knowledge
========================
[The Sum of All Knowledge](http://sum.bykr.org) is a project to visualize the knowledge getting added to Wikidata, Wikipedia and Wikimedia Commons.

It's based on the [Sum of All Paintings](https://www.wikidata.org/wiki/Wikidata:WikiProject_sum_of_all_paintings) Wikidata project.

## Requirements
* PHP > 5.5

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

## License
Code is licensed under the terms of the MIT license (see `LICENSE.txt` for details).

With contributions by:
* [Tisza Gergö](https://github.com/tgr)