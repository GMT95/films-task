<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum')->only('webLogout');
        $this->middleware('guest')->only(['getLoginPage', 'getRegisterPage']);
    }

    public function getLoginPage()
    {
        return view('login');
    }

    public function getRegisterPage()
    {
        return view('register');
    }

    public function webLogout()
    {
        Auth::guard('web')->logout();

        return redirect()->route('login.page');
    }
}
