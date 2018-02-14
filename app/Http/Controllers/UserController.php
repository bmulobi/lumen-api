<?php

namespace App\Http\Controllers;


use Guzzle\Http\Message\Header;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Contracts\Auth\Factory as AuthFactory;
use Illuminate\Support\Facades\Hash;

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
        $this->middleware('auth', ['except' => ['register', 'login']]);
    }

    public function register(Request $request)
    {
        $this->validate($request,
            [
                'name' => 'required',
                'email' => 'required|email',
                'password' => 'required|confirmed'
            ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => app('hash')->make($request->password)
        ]);

        //$auth = app(AuthFactory::class)->guard();
       // $auth->login($user);

        return response($user);
    }

    public function login(Request $request)
    {
        // email must be unique in db
        $user = User::whereEmail($request->email)->first();

        //dd($user->name, $user->email);

        if (! is_null($user) && Hash::check($request->password, $user->password)) {

            return $user->createToken('my token-')->accessToken;;
        }
        return "invalid credentials";



        //$auth = app(AuthFactory::class)->guard();


//        if ($auth->attempt([$request->email, $request->password])) {
//
//        }

            //return User::where('email', $request->email)->first()->createToken('my token-')->accessToken;

        //dd($auth->attempt([$request->email, $request->password]));

//        if (!$auth->attempt([$request->email, $request->password])) {
//            return back()->withErrors([
//                'message' => "Invalid credentials"
//            ]);
//        }
//
//        return redirect()->home();
//        $pwd = request('password');
//
//        $user = User::where('email', request('email'))->where('password', bcrypt('$pwd'))->first();
//        dd($user);
//        $token = $user->createToken('my token-')->accessToken;
//
//        return $token;

        //if (auth()->attempt(request(['email', 'password']))) {
//            return User::where('email', request('email'))->first()->createToken('my token-')->accessToken;
//        } else {
//            return ["error" => "Invalid credentials"];
//        }


    }

    public function test(Request $request)
    {
       // return $request->user();
        return $request->email;
    }



//if ($this->hasValidCredentials($user, $credentials)) {
//$this->login($user, $remember);
//
//return true;
//}

//    protected function hasValidCredentials($user, $credentials)
//    {
//        return ! is_null($user) && $this->provider->validateCredentials($user, $credentials);
//    }
}
/*
 eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiIsImp0aSI6IjBjN2VkYWE4YzZiYTc3NDIzMGRiYmU4YzljN2EwN2Y3MmM2MTUwNjM5YWJlYWE5OTVjM2FiZjk0ZTdkNTU0ZDZmMDBjMTU2Mzk3NTFkYTU5In0.eyJhdWQiOiIxIiwianRpIjoiMGM3ZWRhYThjNmJhNzc0MjMwZGJiZThjOWM3YTA3ZjcyYzYxNTA2MzlhYmVhYTk5NWMzYWJmOTRlN2Q1NTRkNmYwMGMxNTYzOTc1MWRhNTkiLCJpYXQiOjE1MTg2NDA5NTUsIm5iZiI6MTUxODY0MDk1NSwiZXhwIjoxNTUwMTc2OTU1LCJzdWIiOiI0Iiwic2NvcGVzIjpbXX0.geLW3CkkQmbi7CWlbWBBCQvCRqqC52yMPQSK5tZGBOr7C8O0RBAlk6X-biKK3a2CBbPYpHowXlIYbjqKUR1GAmimojlPqLAv1wifCT9-YC3mIKPVevHLCKzl79xW-nR3a8ByuwoS2EhQ8vkUKeKJeQFyL6VGHouVH36ZYQ7lLzswgd0iI2SqfUpIAu9v6D5x8O7UXXzmhos_PnrKZKfzr09MHwL63KHLY26TcTnYfP8CUJ91-w0mHJLF4cFtFRv5-IacljH-gwgJzjq1bbaEGdSELKzNlZ9me8cLv-mtHjjjeUOch_rprTJQo2Ep_oFrxka8q85he03mU4QpJYi9FLRTImirmFgjMKlDZVDszIVSoj1srGPSkhgdkPMs1K4uKoT-Wvcla_Yvpyh5lTsmekY4k1ipI5R7GLR8FXD9QJ3VHq4Gd-kw8xHxqMZ-buyzodWTn5RBg_SdJmhAejTZbs92WDmnNWi9QRdfyT8vkvzNFmElvV2VxKxCyEIar-gaM8c7svZt_mjgipfPxxpXmYP6jR5jYtLGBA5i843ub5cGJXcFYTxommLFKZ81usCj-Cn8xwnAp-4uRphZkiEOsz5uQsy3gv_ZFXzn6Fh02JPb7WdtyJAMnMj9r-d9FC0Kcrgv8cntGSkmnxrlvnNt7IHwnqgUU9E9BjqqneP1P4s


eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiIsImp0aSI6IjVlMDdlY2RkZjhhZDcxYzE0YmJmMDI0OTE0NWZhZjg0NDFjZWI3MTdjMGQ5YjI3ZWEzYzY0Y2FjNDAzNTgxOWFjZDg1YmJhZDNhMTk5NDcxIn0.eyJhdWQiOiIxIiwianRpIjoiNWUwN2VjZGRmOGFkNzFjMTRiYmYwMjQ5MTQ1ZmFmODQ0MWNlYjcxN2MwZDliMjdlYTNjNjRjYWM0MDM1ODE5YWNkODViYmFkM2ExOTk0NzEiLCJpYXQiOjE1MTg2MzQ2MDAsIm5iZiI6MTUxODYzNDYwMCwiZXhwIjoxNTUwMTcwNjAwLCJzdWIiOiI0Iiwic2NvcGVzIjpbXX0.dyPosaKpny2LPZKRtZmmwVNYMeWLbJ1LFpQJlQVlcg_744ijbGvhQuDdpi5ozoTozRM5nB4PGFxSH_BxPeEf6BIdnwTPNlg4Zr0jRJFaS0y2TpprZ3CQBe6fgI9PusypEyDMrpInyJAbzeQORP5W3LaEZbR5G1RwaPFyx-F-ueFEJPnWD-CrpxgiIev-FAmKPLcPoVFdtFZZjllh3Nsf3g0KDXnEkOM1OXCQokJHy6aCDXd_-8emXsH6eg8G_q640hTyI3E7hxT9Zt5fJWLhoa63nhtHSNDPrapO0kze8GfWbQ5ppPpcvqdAEuSAMePkFfUdyMreiYj1JKvFh8ATUGznpYATstMlQXc6ahbAyOrXtDowOGjxnDOxjz7bEkeDQ_a9olnwLCdv8mOBEJ2fpFxLDjGgeX8ZC9Vc4YRBwJ99pNJjPFolFBmCbNSKj-0ah8IXp640zIltmaH2MrxSK4v_iafdVkOI-q3eoBPyf5EUg9ffnE2cpg1WNyN8cE-ZkwnLnYns3ve3Dv1R__LbSopaWAz1whmL-M4XREvhDDZxBS0L9QMtSjVQqchd_901AMTVcI3B8fKRwb8TKDoZzVfWVlssHLF2d32Fy1u8NcwSjocsSo8-cT6tnaMl9mNuWJd8qQ8B2lrz_L1E2x0S6uQE0zAF0kC4HGlZ9u4_GH4
* */
