<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (!$token = JWTAuth::attempt($credentials)) {
            return response()->json(['error' => 'Invalid credentials'], 401);
        }

        $user = Auth::user();

        return response()->json([
            'message' => 'Sign-in successful',
            'role' => $user->role,
            'accessToken' => $token,
            'id' => $user->id
        ]);
    }

    public function register(Request $request)
    {
        $this->validate($request, [
            'username' => 'required|unique:users|string|max:255',
            'email' => 'required|string|email|unique:users|max:255',
            'password' => 'required|string',
        ]);

        $user = User::create([
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password), // Ensure password is hashed
        ]);

        $token = JWTAuth::fromUser($user);

        return response()->json([
            'message' => 'Sign-up successful',
            'user' => $user,
            'accessToken' => $token
        ], 201);
    }
}