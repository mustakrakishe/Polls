<?php

switch ($_SERVER['REQUEST_URI']) {
    case '/':
        echo 'Hi, Guest!';
        break;

    default:
        http_response_code(404);
        echo '404 Page Not Found';
}