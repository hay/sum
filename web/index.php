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
    require 'lib/class-item.php';
    require 'lib/class-work.php';
    require 'lib/class-creator.php';
    require 'lib/class-institution.php';
    require 'lib/class-home.php';

    $templatePath = ABSPATH . "/templates";

    $rendererOptions = [
        "extension" => ".html"
    ];

    $renderer = new Mustache_Engine([
        "loader" => new Mustache_Loader_FilesystemLoader(
            $templatePath, $rendererOptions
        ),
        "partials_loader" => new Mustache_Loader_FilesystemLoader(
            $templatePath, $rendererOptions
        )
    ]);

    $app = new \Slim\Slim();

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
            echo $renderer->render("404", new Page());
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
            echo $renderer->render($item->getPageType(), $item);
        }
    }

    // Homepage
    $app->get("/", function() use ($renderer) {
        echo $renderer->render("home", new Home());
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