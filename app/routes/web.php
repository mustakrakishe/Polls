<?php

use App\Http\Controllers\AuthController;
use App\Http\Requests\Auth\RegisterRequest;
use Core\Validation\Validator;
use Core\View;

/**
 * @var Core\Router $router
 */

$router->get('/', function () {
    View::render('guest');
});

$router->get('/register', [new AuthController(new View), 'showForm']);

$router->post('/register', function () {
    $request    = new RegisterRequest($_POST, new Validator);
    $controller = new AuthController(new View);

    return $controller->register($request);
});