<?php

namespace Core;

use Core\Contracts\ViewInterface;

class View implements ViewInterface
{
    public static function render(string $view, array $parameters = [])
    {
        $viewRelativePath = str_replace('.', DIRECTORY_SEPARATOR, $view) . '.php';

        include join(DIRECTORY_SEPARATOR, [
            __DIR__,
            '..',
            'resources',
            'views',
            $viewRelativePath,
        ]);
    }
}