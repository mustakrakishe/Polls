<?php

require __DIR__ . '/vendor/autoload.php';

use Core\Application;
use Core\Router;

foreach (file('.env', FILE_SKIP_EMPTY_LINES) as $assigment) {
    putenv($assigment);
}

$router = new Router;

include 'routes/web.php';

$app = new Application(
    $router
);

$app->run();