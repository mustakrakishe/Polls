<?php

namespace Core;

use Core\Contracts\ViewInterface;

class Controller
{
    protected $view;

    public function __construct(ViewInterface $view)
    {
        $this->view = $view;
    }
}