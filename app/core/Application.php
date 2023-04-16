<?php

namespace Core;

use Core\Contracts\RouterInterface;
use Exception;

class Application
{
    protected RouterInterface $router;

    public function __construct(RouterInterface $router)
    {
        $this->router = $router;
    }

    public function run()
    {
        $url    = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $method = $_SERVER['REQUEST_METHOD'];

        try {
            $this->router->route($url, $method);
        } catch (Exception $e) {
            http_response_code($e->getCode());
            echo 'Error ' . $e->getCode() . ': ' . $e->getMessage();
        }
    }
}