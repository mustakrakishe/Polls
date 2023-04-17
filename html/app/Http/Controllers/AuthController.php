<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\RegisterRequest;
use App\Models\User;
use Core\Controller;

class AuthController extends Controller
{
    public function showForm()
    {
        $this->view->render('auth.register');
    }

    public function register(RegisterRequest $request)
    {
        User::create([
            'email'         => $request->input('email'),
            'password_hash' => md5($request->input('password')),
            'token_hash'    => md5(random_bytes(getenv('API_TOKEN_LENGTH'))),
        ]);

        header('Location: /personal');
    }
}