<?php

namespace App\Http\Controllers;

use App\Http\Requests\AuthLoginRequest;
use App\Http\Requests\AuthRegisterRequest;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(AuthRegisterRequest $request) {
        $validated = $request->validated();
        $isExist = User::where('email', $validated['email'])->first();
        if($isExist) {
            return response()->json(['message' => 'Email already exists'], 400);
        }

        $validated['password'] = Hash::make($validated['password']);
        $user = User::create($validated);
        
        event(new Registered($user));
        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json(['data' => $user, 'token' => $token,], 201);
    }

    public function login(AuthLoginRequest $request) {
        $validated = $request->validated();

        $user = User::where('email', $validated['email'])->first();
        if(!$user) {
            return response()->json(['message' => 'User is not defined'], 400);
        }

        $isPass = !Hash::check($validated['password'], $user->password);
        if($isPass) {
            return response()->json(['message' => 'Password is not correct'], 400);
        }

        $token = $user->createToken('auth_token')->plainTextToken;
        return response()->json(['token' => $token,], 200);
    }

    public function logout(Request $request) {
        $request->user()->tokens()->delete();
        return response()->json(['message' => 'Logout successfully'], 200);
    }
}
