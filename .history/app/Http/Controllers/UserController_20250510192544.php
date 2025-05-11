<?php

namespace App\Http\Controllers;

use App\Exceptions\ErrorException;
use App\Http\Services\UserService;
use Illuminate\Http\Request;

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

            return response()->json(['data' => $result['data']], $result['status']);
        } catch (ErrorException $err) {
            return $err->throw($request);
        }
    }
}
