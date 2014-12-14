<?php
    define('ABSPATH', dirname(__FILE__));

    if (!file_exists(ABSPATH . '/config.php')) {
        die("Please create a config.php file. Use config-sample.php as an example.");
    }

    require 'config.php';
    require 'vendor/autoload.php';
    require 'lib/class-properties.php';
    require 'lib/class-items.php';
    require 'lib/class-page.php';
    require 'lib/class-wikidataitem.php';
    require 'lib/class-wikipediaarticle.php';
    require 'lib/class-wikidataquery.php';
    require 'lib/class-item.php';

    $app = new \Slim\Slim();

    function render($template, $obj) {
        $loader = new Twig_Loader_Filesystem(ABSPATH . "/templates");

        $renderer = new Twig_Environment($loader, [
            "cache" => ABSPATH . "/cache",
            "debug" => DEBUG
        ]);

        if (DEBUG)  {
            $renderer->addExtension(new Twig_Extension_Debug());
        }

        $data = new ArrayObject($obj);
        echo $renderer->render("$template.html", $data->getArrayCopy());
    }

    function renderPage($id, $format = "html") {
        global $app, $renderer;

        // Check for Q items
        if (strtolower($id[0]) == "q") {
            // FIXME: why do we need PATH here?
            $app->redirect(PATH . "/" . substr($id, 1));
        }

        try {
            $item = new Item($id);
        } catch (Exception $e) {
            render("404", new Page());
            error_log($e->getMessage());

            if (DEBUG) {
                throw $e;
            } else {
                return;
            }
        }

        if ($format == "json") {
            echo json_encode($item);
        } else {
            render($item->getPageType(), $item);
        }
    }

    // Homepage
    $app->get("/", function() {
        render("home", new Page());
    });

    // Redirect old urls
    $app->get("/:type/:id", function($type, $id) use ($app) {
        $app->redirect(PATH . "/$id");
    });

    $app->get("/:id.json", function($id) use ($app) {
        $app->response->headers->set('Content-Type', 'application/json');
        renderPage($id, "json");
    });

    // Conventional URLS
    $app->get("/:id", function($id) {
        renderPage($id);
    });

    $app->run();