<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function register(Request $request){
        $fields = $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:8|confirmed',
        ]);
        $user = User::create($fields);

        $token = $user->createToken($request->name);

        return response()->json([
            'access_token' => $token->plainTextToken,
            'user' => $user,
            'message' => 'You successfully registered'
        ], 200);

    }

    public function login(Request $request){
        $request->validate([
            'email' => 'required|exists:users',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();

        if (! $user || ! Hash::check($request->password, $user->password)) {
            return response()->json(['error' => 'The provided credentials are incorrect'], 401);
        }
        $token = $user->createToken($user->name);

        return response()->json([
            'access_token' => $token->plainTextToken,
            'user' => $user,
            'message' => 'You logged in successfully'
        ], 200);

    }

    public function logout(Request $request){
        
        $request->user()->tokens()->delete();

        return response()->json(['message' => 'User logged out successfully'], 200);

    }
}
