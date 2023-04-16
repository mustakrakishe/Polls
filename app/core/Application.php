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
        session_start();

        $url    = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $method = $_SERVER['REQUEST_METHOD'];

        try {
            $this->router->route($url, $method);
        } catch (Exception $e) {
            if ($e->getCode() === 422) {
                http_response_code(303);
                header('Location: ' . $_SERVER['HTTP_REFERER']);

                return;
            }

            http_response_code($e->getCode());
            echo 'Error ' . $e->getCode() . ': ' . $e->getMessage();
        }
    }
}