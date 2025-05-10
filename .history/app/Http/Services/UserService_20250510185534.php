<?php

use App\Models\User;

class UserService
{
    public function getProfileService($userId)
    {
        $user =  User::where("id", $userId)->first();
        if (!$user) {
            return 
        }
    }
}
