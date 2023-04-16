<?php

use Core\View;

/**
 * @var Core\Router $router
 */

$router->get('/', function () {
    View::render('guest');
});

$router->get('/register', function () {
    View::render('auth.register');
});