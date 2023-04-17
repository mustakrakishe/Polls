<?php

namespace App\Http\Requests\Auth;

use Core\Contracts\AbstractRequest;

class LoginRequest extends AbstractRequest
{
    protected function rules() : array
    {
        return [
            'email' => [
                'required',
                'email',
            ],
            'password' => [
                'required',
                'min:4'
            ],
        ];
    }
}