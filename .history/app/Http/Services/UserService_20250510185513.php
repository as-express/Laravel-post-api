<?php

use App\Models\User;

class UserService
{
    public function getProfileService($userId)
    {
        return User::where("id", $userId)->first();
    }
}
