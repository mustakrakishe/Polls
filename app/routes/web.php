<?php

use Core\View;

/**
 * @var Core\Router $router
 */

$router->get('/', function () {
    View::make('guest', 'Polls');
});