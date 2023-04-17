<?php

namespace App\Http\Controllers;

use Core\Controller;

class UserController extends Controller
{
    public function index()
    {
        $this->view->render('user.personal');
    }
}