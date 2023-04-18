<?php

namespace Core;

use Core\Contracts\AbstractRequest;
use Core\Contracts\RouterInterface;
use Core\Contracts\ViewInterface;
use Core\ORM\Contracts\ModelInterface;
use Core\Validation\Contracts\ValidatorInterface;
use Exception;
use ReflectionMethod;

class Application
{
    protected RouterInterface $router;
    protected ViewInterface $view;
    protected ModelInterface $model;
    protected ValidatorInterface $validator;

    public function __construct(RouterInterface $router, ModelInterface $model, ViewInterface $view, ValidatorInterface $validator)
    {
        $this->router       = $router;
        $this->view         = $view;
        $this->model        = $model;
        $this->validator    = $validator;
    }

    public function run()
    {
        session_start();

        $url    = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $method = $_SERVER['REQUEST_METHOD'];

        try {
            $this->runAction(
                $this->router->route($url, $method)
            );
        } catch (Exception $e) {
            if ($e->getCode() === 422) {
                $header = 'Location: ' . $_SERVER['HTTP_REFERER'];

                return header($header, true, 303);
            }

            if ($e->getCode() === 401) {
                return header('Location: /', true, 303);
            }

            http_response_code($e->getCode());
            echo 'Error ' . $e->getCode() . ': ' . $e->getMessage();
        }
    }

    protected function runAction($action)
    {
        if (is_array($action)) {
            $action     = $this->prepareCallback($action);
            $request    = $this->makeRequiredRequest($action);
        }

        call_user_func($action, $request ?? null);
    }

    protected function prepareCallback(array $callback)
    {
        $callback[0] = $this->newController($callback[0]);

        return $callback;
    }

    protected function newController(string $class) : Controller
    {
        return new $class($this->model, $this->view);
    }

    protected function makeRequiredRequest(array $callback)
    {
        $method         = new ReflectionMethod($callback[0], $callback[1]);
        $parameters     = $method->getParameters();

        if ($parameters === []) {
            return null;
        }

        $requestArgument    = $parameters[0];
        $requestClass       = $requestArgument->getType()
                                              ->getName();

        return $this->newRequest($requestClass);
    }

    protected function newRequest(string $class) : AbstractRequest
    {
        return new $class($_POST, $this->validator);
    }
}