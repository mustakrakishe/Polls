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
}