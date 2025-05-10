<?php

use App\Exceptions\ErrorException;
use App\Jobs\EmailJob;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AuthService
{
    public function registerService($data)
    {
        $isExist = User::where('email', $data['email'])->first();
        if ($isExist) {
            throw new ErrorException('Email already exists', 400);
        }
        $data['password'] = Hash::make($data['password']);
        $user = User::create([
            'email' => $data['email'],
            'name' => $data['name'],
            'password' => $data['password'],
            'verification_token' => Str::random(32),
        ]);
        EmailJob::dispatch($user);
        $token = $user->createToken('auth_token')->plainTextToken;

        return (object)[
            'data' => $user,
            'token' => $token,
            'status' => 201
        ];
    }

    public function loginService($data)
    {
        $user = User::where('email', $data['email'])->first();
        if (!$user) {
            throw new ErrorException('User in not defined', 400);
        }
        $isPass = !Hash::check($data['password'], $user->password);
        if ($isPass) {
            throw new ErrorException('Password is not right', 400);
        }

        $token = $user->createToken('auth_token')->plainTextToken;
        return (object)[
            'token' => $token,
            'status' => 200
        ];
    }

    public function verifyService($token)
    {
        $user = User::where('verification_token', $token)->firstOrFail();
        $user->email_verified_at = now();
        $user->save();
        $token = $user->createToken('auth_token')->plainTextToken;
        return response()->json([
            'message' => 'Email verified',
            'token' => $token,
            'status' => 200
        ]);
    }
}
