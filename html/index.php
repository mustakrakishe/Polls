<?php

require __DIR__ . '/vendor/autoload.php';

use Core\Application;
use Core\Connection;
use Core\ORM\Model;
use Core\ORM\QueryBuilder;
use Core\Router;
use Core\Validation\Validator;
use Core\View;

foreach (file('.env', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) as $assigment) {
    putenv($assigment);
}

$router = new Router;

include 'routes/web.php';

$connection     = new Connection(
                    getenv('DB_DRIVER'),
                    getenv('DB_HOST'),
                    getenv('DB_PORT'),
                    getenv('DB_DATABASE'),
                    getenv('DB_USERNAME'),
                    getenv('DB_PASSWORD')
                );
$queryBuilder   = new QueryBuilder($connection);
$model          = new Model($queryBuilder);
$validator      = new Validator($model);

$app = new Application(
    $router,
    $model,
    new View,
    $validator
);

$app->run();