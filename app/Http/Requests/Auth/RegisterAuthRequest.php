<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class RegisterAuthRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function rules(){
        return [
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|confirmed' // This ensures password_confirmation matches
        ];
    }
    
    public function messages(){
        return [
            'name.required' => 'The name field is required',
            'password.required' => 'The password field is required',
            'password.confirmed' => 'The confirm password does not match'
        ];
    }
    
    public function attributes(){
        return [
            'email' => 'Email Address',
            'password_confirmation' => 'Confirm Password'
        ];
    }
}
