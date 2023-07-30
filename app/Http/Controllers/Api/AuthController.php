<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Traits\ResponseWrapper;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Password;

class AuthController extends Controller
{
    use ResponseWrapper;

    public function register(Request $request) {

        $request->validate([
            "name" => "required|min:3",
            "email" => "required|email|unique:users",
            "password" => ["required", "confirmed", Password::min(8)->mixedCase()]
        ]);

        $user = User::create([
            "name" => $request->name,
            "email" => $request->email,
            "password" => bcrypt($request->password)
        ]);

        /* TODO: Login User after creation */

        return $this->responseCreated([], "User with email: {$user->email} Created Successfully");
    }

    public function login(Request $request) {

        $request->validate([
            "email" => "email|required",
            "password" => "required"
        ]);

        $credentials = $request->only(['email', 'password']);

        if(!auth()->attempt($credentials)) {

            return $this->responseInvalidPayload(
            [
                "password" => [
                    "Invalid Credentials"
                ]
            ],
            "The given data was invalid");
        }

        $user = User::query()->where("email", $request->email)->first();
        $token = $user->createToken("auth-token")->plainTextToken;

        return $this->responseOk(
            [
                "token" => $token,
                "user" => $user,
                "redirect_url" => route("films.list.page")
            ],
            "Login Successful"
        );
    }
}
