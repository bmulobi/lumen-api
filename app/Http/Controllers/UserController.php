<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Http\Response;

use App\User;

class UserController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['register']]);
    }

    public function register(Request $request)
    {
        $user = User::create(
            $request->all()
        );

        return response($user);
    }

    //
}
