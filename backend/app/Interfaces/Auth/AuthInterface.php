<?php

namespace App\Interfaces\Auth;

interface AuthInterface
{
    public function register($request);
    public function login($request);
    public function handleGoogleCallback();
    public function destroy();
}
