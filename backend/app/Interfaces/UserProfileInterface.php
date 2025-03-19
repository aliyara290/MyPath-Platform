<?php

namespace App\Interfaces;

interface UserProfileInterface
{
    public function getUser();
    public function updateUser($request);
}