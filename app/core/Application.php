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
        try {
            $this->router->route(
                $_SERVER['REQUEST_URI'],
                $_SERVER['REQUEST_METHOD']
            );
        } catch (Exception $e) {
            http_response_code($e->getCode());
            echo 'Error ' . $e->getCode() . ': ' . $e->getMessage();
        }
    }
}