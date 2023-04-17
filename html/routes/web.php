<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use Core\Validation\Validator;
use Core\View;

/**
 * @var Core\Router $router
 */

$router->get('/', function () {
    if (isset($_SESSION['user_id'])) {
        header('Location: /personal');
    }

    View::render('guest');
});

$router->get('/register', [new AuthController(new View), 'showRegisterPage']);

$router->post('/register', function () {
    $request    = new RegisterRequest($_POST, new Validator);
    $controller = new AuthController(new View);

    return $controller->register($request);
});

$router->get('/login', [new AuthController(new View), 'showLoginPage']);

$router->post('/login', function () {
    $request    = new LoginRequest($_POST, new Validator);
    $controller = new AuthController(new View);

    return $controller->login($request);
});

$router->get('/logout', [new AuthController(new View), 'logout']);

$router->get('/personal', [new UserController(new View), 'index']);