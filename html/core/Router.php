<?php

namespace Core;

use Core\Contracts\RouterInterface;
use Exception;

class Router implements RouterInterface
{
    protected array $routes = [];

    public function add(string $method, string $url, $action)
    {
        return $this->routes[$url][$method] = $action;
    }

    public function get(string $url, $action)
    {
        return $this->add('GET', $url, $action);
    }

    public function post(string $url, $action)
    {
        return $this->add('POST', $url, $action);
    }

    public function route(string $url, string $method)
    {
        $this->validate($url, $method);
        
        return $this->routes[$url][$method];
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