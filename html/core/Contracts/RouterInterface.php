<?php

namespace Core\Contracts;

interface RouterInterface
{
    public function add(string $method, string $url, callable $callback);
    public function get(string $url, callable $callback);
    public function post(string $url, callable $callback);
    public function route(string $url, string $method);
}