<?php

namespace App\Http\Requests\Auth;

use Core\Contracts\AbstractRequest;

class RegisterRequest extends AbstractRequest
{
    protected function rules() : array
    {
        return [
            'email' => [
                'required',
                'email',
                'unique:users,email'
            ],
            'password' => [
                'required',
                'min:4'
            ],
        ];
    }
}