<?php

namespace Controllers;

use Core\Controller;

class AuthController extends Controller
{
    public function showRegisterPage()
    {
        $this->view->render('auth.register');
    }
}