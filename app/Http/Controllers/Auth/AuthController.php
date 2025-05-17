<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $rules = [
            'email' => 'required|email|exists:users,email',
            'password' => 'required'
        ];

        $customMessages = [
            'password.required' => 'The password field is required'
        ];

        $attributes = [
            'email' => 'Email Address'
        ];

        $validator = Validator::make($request->all(), $rules, $customMessages, $attributes);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(),
                'code' => 422
            ], 422);
        }

        $validated = $validator->validated();

        $user = User::where('email', $validated['email'])->first();

        if (!$user || !Hash::check($validated['password'], $user->password)) {
            return response()->json([
                'message' => 'Invalid Credentials',
                'code' => 401
            ], 401);
        }

        $token = Str::random(60);

        $user->api_token = hash('sha256', $token);
        $user->save();

        return response()->json([
            'data' => $user,
            'message' => 'Login Successfully',
            'code' => 200
        ], 200);
    }

    public function register(Request $request)
    {
        $rules = [
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email',
            'password' => 'required'
        ];

        $customMessages = [
            'name.required' => 'The name field is required',
            'password.required' => 'The password field is required'
        ];

        $attributes = [
            'email' => 'Email Address'
        ];

        $validator = Validator::make($request->all(), $rules, $customMessages, $attributes);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(),
                'code' => 422
            ], 422);
        }

        $validated = $validator->validated();

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => bcrypt($validated['password']),
        ]);

        return response()->json([
            'data' => $user,
            'message' => 'User Created Successfully',
            'code' => 200
        ], 200);
    }
}
