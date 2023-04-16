<?php

namespace Core\Contracts;

interface ViewInterface
{
    public static function render(string $view, array $parameters = []);
}