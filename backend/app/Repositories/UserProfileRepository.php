<?php

namespace App\Repositories;

use App\Http\Resources\V1\AuthUserResource;
use App\Interfaces\UserProfileInterface;
use App\Models\User;
use App\Traits\HttpResponses;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class UserProfileRepository implements UserProfileInterface
{
    use HttpResponses;
    public function getUser()
    {
        try {
            $user = Auth::user();
            if (!$user) {
                return $this->error(
                    "",
                    404,
                    "User not found"
                );
            }
            return new AuthUserResource($user);
        } catch (Exception $e) {
            return $this->error(
                "",
                500,
                "Server error"
            );
        }
    }
    public function updateUser($request)
    {
        try {
            $userId = Auth::id();
            if (!$userId) {
                return $this->error(
                    "",
                    404,
                    "User not found"
                );
            }
            $user = User::find($userId);

            if ($request->hasFile('avatar')) {
                if ($user->avatar) {
                    Storage::disk('public')->delete($user->avatar);
                } 
                $avatarPath = $request->file('avatar')->store('avatars', 'public');
                $user->avatar = $avatarPath;
            }

            $user->update([
                "name" => $request->fullName,
                "email" => $request->email,
                "avatar" => $request->avatar,
                "position" => $request->position,
                "website" => $request->website,
                "bio" => $request->bio,
                "joined" => $request->joined,
            ]);

            return response()->json(["message" => "Profile updates successfully"], 201);
        } catch (Exception $e) {
            return $this->error(
                "",
                500,
                $e
            );
        }
    }
}
