<?php

require __DIR__ . '/vendor/autoload.php';

use Core\Application;
use Core\Router;

$router = new Router;

include 'routes/web.php';

$app = new Application(
    $router
);

$app->run();