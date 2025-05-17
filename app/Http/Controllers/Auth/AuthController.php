<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str; 

class AuthController extends Controller
{
    public function login(Request $request){
        $validated = $request->validate([
            'email' => 'required|email|exists:users,email',
            'password' => 'required'
        ],[
            'email.required' => 'The email field is required',
            'email.email' => 'The email field should be valid',
            'email.exists' => 'The email does not exist',
            'password' => 'The password field is required'
        ]);

        $user = User::where('email', $validated['email'])->first();

        if(!$user || !Hash::check($validated['password'], $user->password)){
            return response()->json([
                'message' => 'Invalid Credentials',
                'code' => 401
            ],401);
        }

        $token = Str::random(60);

        $user->api_token = hash('sha256', $token);
        $user->save();

        return response()->json([
            'date' => $user,
            'message' => 'Login Successfully',
            'code' => 200
        ],200);

    }

    public function register(Request $request){
        $validated = $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email',
            'password' => 'required'
        ],[
            'name.required' => 'The name field is required',
            'email.required' => 'The email field is required',
            'email.email' => 'The email field should be valid',
            'email.unique' => 'The email should unique',
            'password' => 'The password field is required'
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => bcrypt($validated['password']),
        ]);

        return response()->json([
            'date' => $user,
            'message' => 'User Created Successfully',
            'code' => 200
        ],200);
    }
}
