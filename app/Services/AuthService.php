<?php

namespace App\Services;

use App\Models\User;
use App\Services\Interfaces\AuthServiceInterface;
use Illuminate\Http\Request;

class AuthService implements AuthServiceInterface
{
    public function register(Request $request): array
    {
        $user = User::create([
            "name" => $request->name,
            "email" => $request->email,
            "password" => bcrypt($request->password)
        ]);

        $credentials = $request->only(['email', 'password']);

        /* Login User after account creation */
        $loginSuccess = auth()->attempt($credentials);

        $token = $user->createToken("auth-token")->plainTextToken;

        return ['token' => $token, 'user' => $user, 'loginSuccess' => $loginSuccess];
    }

    public function login(Request $request): array
    {
        $credentials = $request->only(['email', 'password']);

        /* Return Error on Login Attempt Failed */
        if (!auth()->attempt($credentials)) {
            return [
                "error" => [
                    "body" => [
                        "password" => [
                            "Invalid Credentials"
                        ]
                    ],
                    "msg" => "The given data was invalid"
                ],
                "token" => null,
                "user" => null
            ];
        }

        $user = User::query()->where("email", $request->email)->first();

        $token = $user->createToken("auth-token")->plainTextToken;

        return [
            "error" => null,
            "token" => $token,
            "user" => $user
        ];
    }

    public function logout()
    {
        $user = auth()->user();

        $user->tokens()->delete();
    }
}
