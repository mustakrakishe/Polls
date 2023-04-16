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
        $this->validate($url, $method);
        
        return call_user_func(
            $this->routes[$url][$method]
        );
    }

    protected function validate(string $url, string $method)
    {
        if (empty($this->routes[$url])) {
            return $this->returnPageNotFound();
        }

        if (empty($this->routes[$url][$method])) {
            return $this->returnMethodNotAllowed();
        }
    }

    protected function returnMethodNotAllowed()
    {
        http_response_code(405);
        echo 'Error 405: Method Not Allowed';
    }

    protected function returnPageNotFound()
    {
        http_response_code(404);
        echo 'Error 404: Page Not Found';
    }
}