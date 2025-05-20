<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginAuthRequest;
use App\Http\Requests\Auth\RegisterAuthRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function login(LoginAuthRequest $request)
    {

        $validated = $request->validated();

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

    public function register(RegisterAuthRequest $request)
    {

        $validated = $request->validated();

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

    public function logout(Request $request)
    {
        $user = User::where('api_token', $request->api_token)->first();

        if (!$user) {
            return response()->json([
                'message' => 'Unauthenticated.',
                'code' => 401
            ], 401);
        }

        // Clear the token
        $user->api_token = null;
        $user->save();

        return response()->json([
            'message' => 'Logout successful.',
            'code' => 200
        ], 200);
    }
}
