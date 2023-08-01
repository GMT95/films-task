<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginUserRequest;
use App\Http\Requests\RegisterUserRequest;
use App\Services\Interfaces\AuthServiceInterface;
use App\Traits\ResponseWrapper;


class AuthController extends Controller
{
    use ResponseWrapper;

    public function __construct(protected AuthServiceInterface $authService)
    {
    }

    public function register(RegisterUserRequest $request)
    {

        $registerResponse = $this->authService->register($request);

        $user = $registerResponse['user'];

        /* Redirect to Films on login success */
        return $this->responseCreated(
            [
                "token" => $registerResponse['token'],
                "user" => $user,
                "redirect_url" => $registerResponse['loginSuccess'] ? route("films.list.page") : route('register.page')
            ],
            "User with email: {$user->email} Created Successfully"
        );
    }

    public function login(LoginUserRequest $request)
    {
        $loginResponse = $this->authService->login($request);
        $loginError = $loginResponse['error'];

        if(isset($loginError)) {
            return $this->responseInvalidPayload($loginError['body'], $loginError['msg']);
        }

        return $this->responseOk(
            [
                "token" => $loginResponse['token'],
                "user" => $loginResponse['user'],
                "redirect_url" => route("films.list.page")
            ],
            "Login Successful"
        );
    }

    public function logout()
    {
        $this->authService->logout();

        return $this->responseOk([
            "redirect_url" => route("login.page")
        ], "User logged out");
    }
}
