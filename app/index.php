<?php

require __DIR__ . '/vendor/autoload.php';

use Core\View;

switch ($_SERVER['REQUEST_URI']) {
    case '/':
        View::make('guest', 'Polls');
        break;

    default:
        http_response_code(404);
        echo '404 Page Not Found';
}