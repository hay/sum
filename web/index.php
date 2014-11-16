<?php
    define('ABSPATH', dirname(__FILE__));

    if (!file_exists(ABSPATH . '/config.php')) {
        die("Please create a config.php file. Use config-sample.php as an example.");
    }

    require 'config.php';
    require 'vendor/autoload.php';
    require 'lib/class-properties.php';
    require 'lib/class-page.php';
    require 'lib/class-item.php';
    require 'lib/class-work.php';
    require 'lib/class-creator.php';

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

    function renderPage($id, $page) {
        global $app, $renderer;

        // Check for Q items
        if (strtolower($id[0]) == "q") {
            // FIXME: why do we need PATH here?
            $app->redirect(PATH . "/$page/" . substr($id, 1));
        }

        try {
            if ($page == "work") {
                $item = new Work($id);
            }

            if ($page == "creator") {
                $item = new Creator($id);
            }
        } catch (Exception $e) {
            echo $renderer->render("404", new Page());
            error_log($e->getMessage());

            if (DEBUG) {
                throw $e;
            } else {
                return;
            }
        }

        echo $renderer->render($page, $item);
    }

    $app->get("/creator/:id", function($id) {
        renderPage($id, "creator");
    });

    $app->get("/work/:id", function($id) {
        renderPage($id, "work");
    });

    $app->run();