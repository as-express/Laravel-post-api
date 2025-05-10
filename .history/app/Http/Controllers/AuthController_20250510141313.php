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
        $user = User::create($validated)
    }
}
