<?php

class UserService
{
    public function getProfileService()
    {
        return User::where("id", $userId)->first();
    }
}
