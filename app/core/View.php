<?php

namespace Core;

use Core\Contracts\ViewInterface;

class View implements ViewInterface
{
    public static function make(string $view, array $parameters = [])
    {
        $viewRelativePath = str_replace('.', DIRECTORY_SEPARATOR, $view) . '.php';

        include('Views' . DIRECTORY_SEPARATOR . $viewRelativePath);
    }
}