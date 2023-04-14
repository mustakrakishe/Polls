<?php

require __DIR__ . '/vendor/autoload.php';

use Core\Request;
use Core\Router;

$router = new Router;

include 'routes/web.php';

Request::resolve($router->list());