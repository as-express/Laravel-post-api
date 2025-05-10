<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function index(){
        return User::all();
    }

    public function profile(Request $request) {
        echo $request->user()->id();
        // return User::where("id", $request->user()->id);
    }
}
