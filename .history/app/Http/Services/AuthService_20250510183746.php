<?php

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
            return response()->json(['message' => 'Email already exists'], 400);
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
        ];
    }

    public function loginService() {}
}
