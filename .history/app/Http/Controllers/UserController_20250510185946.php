<?php

namespace App\Http\Controllers;

use App\Exceptions\ErrorException;
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
        try {
            $userId =  $request->user()->id;
            $result = $this->userService->getProfileService($userId);
        } catch (ErrorException $err) {
            return $err->throw($request);
        }
    }
}
