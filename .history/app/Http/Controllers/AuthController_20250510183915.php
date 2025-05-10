<?php

namespace App\Http\Controllers;

use App\Http\Requests\AuthLoginRequest;
use App\Http\Requests\AuthRegisterRequest;
use App\Jobs\EmailJob;
use Illuminate\Http\Request;
use App\Models\User;
use AuthService;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    protected $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function register(AuthRegisterRequest $request)
    {
        $validated = $request->validated();
        $result = $this->authService->registerService($validated);

        return response()->json(['data' => $result->data], 201);
    }

    public function login(AuthLoginRequest $request)
    {
        $validated = $request->validated();

        $user = User::where('email', $validated['email'])->first();
        if (!$user) {
            return response()->json(['message' => 'User is not defined'], 400);
        }

        $isPass = !Hash::check($validated['password'], $user->password);
        if ($isPass) {
            return response()->json(['message' => 'Password is not correct'], 400);
        }

        $token = $user->createToken('auth_token')->plainTextToken;
        return response()->json(['token' => $token,], 200);
    }

    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();
        return response()->json(['message' => 'Logout successfully'], 200);
    }

    public function verify(Request $request)
    {
        $user = User::where('verification_token', $request->token)->firstOrFail();
        $user->email_verified_at = now();
        $user->save();
        $token = $user->createToken('auth_token')->plainTextToken;
        return response()->json([
            'message' => 'Email verified',
            'token' => $token
        ]);
    }
}
