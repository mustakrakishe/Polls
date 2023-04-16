<?php

require __DIR__ . '/vendor/autoload.php';

use Core\Router;

$router = new Router;

include 'routes/web.php';

$router->route(
    $_SERVER['REQUEST_URI'],
    $_SERVER['REQUEST_METHOD']
);