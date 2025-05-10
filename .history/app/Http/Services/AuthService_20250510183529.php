<?php


class AuthService {
    public function registerService() {
        $isExist = User::where( 'email', $validated['email'])->first();
        if($isExist) {
            return response()->json(['message' => 'Email already exists'], 400);
        }
        $validated['password'] = Hash::make($validated['password']);
        $user = User::create([
    'email'=> $validated['email'],
    'name' => $validated['name'],
    'password' => $validated['password'],
    'verification_token' => Str::random(32),
]);
EmailJob::dispatch($user);
$token = $user->createToken('auth_token')->plainTextToken;
return response()->json(['data' => $user, 'token' => $token,], 201);
    }

    public function loginService() {

    }
}