<?php

namespace App\Http\Controllers;

use App\Models\User;
use Core\Controller;
use Exception;

class UserController extends Controller
{
    public function index()
    {
        if (!isset($_SESSION['user_id'])) {
            throw new Exception('Please, register or login.', 401);
        }

        $user = User::where([
            ['id', $_SESSION['user_id']],
        ])->first();

        $this->view->render('user.personal', compact('user'));
    }
}