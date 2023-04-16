<?php

namespace Core;

use Closure;

class Router
{
    protected array $routes = [];

    public function add(string $method, string $url, Closure $action)
    {
        return $this->routes[$url][$method] = $action;
    }

    public function get(string $url, Closure $action)
    {
        return $this->add('GET', $url, $action);
    }

    public function post(string $url, Closure $action)
    {
        return $this->add('POST', $url, $action);
    }

    public function list() : array
    {
        return $this->routes;
    }

    public function route(string $url, string $method)
    {

        $methods = $this->routes[$url] ?? [];

        if ($methods) {
            $action = $methods[$method] ?? null;

            if ($action) {
                call_user_func($action);
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