<?php

namespace App\Http\Controllers;

use Core\Controller;
use Exception;

class UserController extends Controller
{
    public function index()
    {
        if (!isset($_SESSION['user_id'])) {
            throw new Exception('Please, register or login.', 401);
        }

        $parameters['user'] = $this->model
                                    ->first('users', [
                                        ['id', '=', $_SESSION['user_id']]
                                    ]);

        if (isset($_SESSION['token'])) {
            $parameters['token'] = $_SESSION['token'];

            unset($_SESSION['token']);
        }

        $this->view->render('user.personal', $parameters);
    }
}