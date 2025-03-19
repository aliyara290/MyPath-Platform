<?php

namespace App\Http\Controllers\V1\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\LoginUserRequest;
use App\Http\Requests\V1\StoreUserRequest;
use App\Interfaces\Auth\AuthInterface;
use Laravel\Socialite\Facades\Socialite;

class AuthController extends Controller
{

    private $authInterface;

    public function __construct(AuthInterface $authInterface)
    {
        $this->authInterface = $authInterface;
    }

    public function register(StoreUserRequest $request) {
        return $this->authInterface->register($request);
    }

    public function login(LoginUserRequest $request) {
        return $this->authInterface->login($request);
    }

    public function redirectToGoogle() {
        return Socialite::driver('google')->redirect();
    }
   
    public function handleGoogleCallback() {
        return $this->authInterface->handleGoogleCallback();
    }

    public function destroy() {
        return $this->authInterface->destroy();
    }
}
