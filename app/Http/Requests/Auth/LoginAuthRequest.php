<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class LoginAuthRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(){
        return [
            'email' => 'required|email|exists:users,email',
            'password' => 'required'
        ];
    }
    
    public function messages(){
        return [
            'password.required' => 'The password field is required'
        ];
    }

    public function attributes(){
        return [
            'email' => 'Email Address'
        ];
    }
}


