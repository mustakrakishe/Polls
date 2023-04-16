<?php

use App\Controllers\AuthController;
use Core\View;

/**
 * @var Core\Router $router
 */

$router->get('/', function () {
    View::render('guest');
});

$router->get('/register', [new AuthController(new View), 'showForm']);