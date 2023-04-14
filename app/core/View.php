<?php

namespace Core;

class View
{
    public static function make(string $view, string $title = null, array $parameters = [])
    {
        $title ??= ucfirst($view);

        $viewRelativePath = str_replace('.', DIRECTORY_SEPARATOR, $view) . '.php';

        include('Views' . DIRECTORY_SEPARATOR . $viewRelativePath);
    }
}