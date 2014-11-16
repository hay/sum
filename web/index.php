<?php
    define('ABSPATH', dirname(__FILE__));

    if (!file_exists(ABSPATH . '/config.php')) {
        die("Please create a config.php file. Use config-sample.php as an example.");
    }

    require 'config.php';
    require 'lib/class-properties.php';
    require 'lib/class-page.php';
    require 'lib/class-item.php';
    require 'vendor/autoload.php';

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

    $app->get("/", function() use ($renderer) {
        echo $renderer->render("home", new Page());
    });

    $app->get("/item/:id", function($id) use ($renderer, $app) {
        // Check for Q items
        if (strtolower($id[0]) == "q") {
            // FIXME: why do we need PATH here?
            $app->redirect(PATH . "/item/" . substr($id, 1));
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

        echo $renderer->render("item", $item);

    });

    $app->run();