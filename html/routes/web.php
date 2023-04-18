<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
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

$router->get('/register', [AuthController::class, 'showRegisterPage']);

$router->post('/register', [AuthController::class, 'register']);

$router->get('/login', [AuthController::class, 'showLoginPage']);

$router->post('/login', [AuthController::class, 'login']);

$router->get('/logout', [AuthController::class, 'logout']);

$router->get('/personal', [UserController::class, 'index']);
