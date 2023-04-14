<?php

namespace Core;

class Request
{
    public static function resolve($routes)
    {
        $methods = $routes[$_SERVER['REQUEST_URI']] ?? [];

        if ($methods) {
            $action = $methods[$_SERVER['REQUEST_METHOD']] ?? null;

            if ($action) {
                $action();
                exit;
            }

            http_response_code(405);
            echo 'Error 405: Method Not Allowed';
            exit;
        }

        http_response_code(404);
        echo 'Error 404: Page Not Found';
    }
}
