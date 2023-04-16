<?php

namespace Core;

use Core\Contracts\RouterInterface;

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