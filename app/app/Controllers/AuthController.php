<?php

namespace App\Controllers;

use Core\Controller;

class AuthController extends Controller
{
    public function showForm()
    {
        $this->view->render('auth.register');
    }
}