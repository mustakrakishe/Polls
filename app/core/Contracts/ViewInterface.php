<?php

namespace Core\Contracts;

interface ViewInterface
{
    public static function make(string $view, array $parameters = []);
}