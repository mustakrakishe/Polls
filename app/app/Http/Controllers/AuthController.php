<?php

namespace App\Http\Controllers;

use Core\Controller;

class AuthController extends Controller
{
    public function showForm()
    {
        $this->view->render('auth.register');
    }
}