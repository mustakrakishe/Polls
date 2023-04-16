<?php

namespace Core;

use Core\Contracts\RouterInterface;
use Exception;

class Router implements RouterInterface
{
    protected array $routes = [];

    public function add(string $method, string $url, callable $callback)
    {
        return $this->routes[$url][$method] = $callback;
    }

    public function get(string $url, callable $callback)
    {
        return $this->add('GET', $url, $callback);
    }

    public function post(string $url, callable $callback)
    {
        return $this->add('POST', $url, $callback);
    }

    public function route(string $url, string $method)
    {
        $this->validate($url, $method);
        
        return call_user_func(
            $this->routes[$url][$method]
        );
    }

    protected function validate(string $url, string $method)
    {
        if (empty($this->routes[$url])) {
            throw new Exception('Page Not Found', 404);
        }

        if (empty($this->routes[$url][$method])) {
            throw new Exception('Method Not Allowed', 405);
        }
    }
}