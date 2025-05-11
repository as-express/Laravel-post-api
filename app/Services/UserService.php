<?php

namespace App\Services;

use App\Exceptions\ErrorException;
use App\Models\User;

class UserService
{
    public function getProfileService($userId)
    {
        $user =  User::where("id", $userId)->first();
        if (!$user) {
            throw new ErrorException('User not found', 404);
        }

        return (object)[
            'data' => $user,
            'status' => 200,
        ];
    }
}
