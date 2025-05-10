<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use UserService;

class UserController extends Controller
{
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function profile(Request $request)
    {
        $userId =  $request->user()->id;
        $result = $this->userService->getProfileService($userId);
    }
}
