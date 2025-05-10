<?php

namespace App\Http\Controllers;

use App\Exceptions\ErrorException;
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
        try {
            $validated = $request->validated();
            $result = $this->authService->registerService($validated);

            return response()->json(['data' => $result['data'], 'token' => $result['token']], $result['status']);
        } catch (ErrorException $err) {
            return $err->throw($request);
        }
    }

    public function login(AuthLoginRequest $request)
    {
        try {
            $validated = $request->validated();
            $result = $this->authService->loginService($validated);

            return response()->json(['token' => $result['token']], $result['status']);
        } catch (ErrorException $err) {
            return $err->throw($request);
        }
    }

    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();
        return response()->json(['message' => 'Logout successfully'], 200);
    }

    public function verify(Request $request)
    {
        try {
            $result = $this->authService->verifyService($request - token);
            return response()->json(['token' => $result['token']], $result['status']);
        } catch (ErrorException $err) {
            return $err->throw($request);
        }
    }
}
