<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\User;
use Core\Controller;
use Exception;

class AuthController extends Controller
{
    public function showRegisterPage()
    {
        if (isset($_SESSION['user_id'])) {
            header('Location: /personal');
        }

        $this->view->render('auth.register');
    }

    public function register(RegisterRequest $request)
    {
        if (isset($_SESSION['user_id'])) {
            header('Location: /personal');
        }

        $userId = User::create([
            'email'         => $request->input('email'),
            'password_hash' => md5($request->input('password')),
            'token_hash'    => md5(random_bytes(getenv('API_TOKEN_LENGTH'))),
        ]);

        $_SESSION['user_id'] = $userId;

        header('Location: /personal');
    }


    public function showLoginPage()
    {
        if (isset($_SESSION['user_id'])) {
            header('Location: /personal');
        }

        $this->view->render('auth.login');
    }

    public function login(LoginRequest $request)
    {
        if (isset($_SESSION['user_id'])) {
            header('Location: /personal');
        }
        
        $user = User::where([
            ['email',           $request->input('email')],
            ['password_hash',   md5($request->input('password'))],
        ])->first();

        if (is_null($user)) {
            $_SESSION['errors']['email'][]      = 'Email or Password is wrong.';
            $_SESSION['errors']['password'][]   = 'Email or Password is wrong.';

            $_SESSION['old']['email']           = $request->input('email');
            $_SESSION['old']['password']        = $request->input('password');
            
            throw new Exception('Email or Password is wrong.', 422);
        }

        $_SESSION['user_id'] = $user['id'];

        header('Location: /personal');
    }

    public function logout()
    {
        unset($_SESSION['user_id']);

        header('Location: /');
    }
}