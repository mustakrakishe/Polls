<?php

namespace Core;

use Core\Contracts\ViewInterface;
use Core\ORM\Contracts\ModelInterface;

class Controller
{
    protected ViewInterface $view;
    protected ModelInterface $model;

    public function __construct(ModelInterface $model, ViewInterface $view)
    {
        $this->view     = $view;
        $this->model    = $model;
    }
}