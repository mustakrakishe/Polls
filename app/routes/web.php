<?php

use App\Http\Controllers\AuthController;
use Core\View;

/**
 * @var Core\Router $router
 */

$router->get('/', function () {
    View::render('guest');
});

$router->get('/register', [new AuthController(new View), 'showForm']);
$router->post('/register', [new AuthController(new View), 'register']);