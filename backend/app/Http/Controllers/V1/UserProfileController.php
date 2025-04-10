<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\UpdateUserProfileRequest;
use App\Interfaces\UserProfileInterface;
use Illuminate\Http\Request;

class UserProfileController extends Controller
{
    private $authenticatedUser;

    public function __construct(UserProfileInterface $user) {
        $this->authenticatedUser = $user;
    }
    public function getAuthUser() {
        return $this->authenticatedUser->getUser();
    }
    public function updateAuthUser(UpdateUserProfileRequest $request) {
        return $this->authenticatedUser->updateUser($request);
    }
}
