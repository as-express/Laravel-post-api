<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class AuthController extends Controller
{
    public function register(Request $request) {
        $validated = $request->validated();
        $isExist = User::where('email', $validated['email'])->first();
        if($isExist) {
            return response()->json(['message' => 'Email already exists'], 400);
        }

        $user = User::create($validated);
        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json(['data' => $user, 'token' => $token,], 201);
    }

    public function login(Request $request) {
        $validated = $request->validated();

        $user = User::where('email', $validated['email'])->first();
        if(!$user) {
            return response()->json(['message' => 'User is not defined'], 400);
        }

        $isPass = !$user->validatePassword($validated['password']);
        if($isPass) {
            return response()->json(['message' => 'Password is not correct'], 400);
        }

        $token = $user->createToken('auth_token')->plainTextToken;
        return response()->json(['token' => $token,], 200);
    }
}
