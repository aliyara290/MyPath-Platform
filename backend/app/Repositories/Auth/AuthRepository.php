<?php

namespace App\Repositories\Auth;

use App\Interfaces\Auth\AuthInterface;
use App\Traits\HttpResponses;
use App\Models\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\PersonalAccessToken;
use Laravel\Socialite\Facades\Socialite;

class AuthRepository implements AuthInterface
{
    use HttpResponses;

    public function register($request)
    {
        try {

            $user = User::create([
                "name" => $request->name,
                "email" => $request->email,
                "username" => $request->username,
                "password" => Hash::make($request->password),
            ]);

            if (!$user) {
                return $this->error(
                    "",
                    422,
                    "Failed to register"
                );
            }

            return $this->success([
                "user" => $user,
                "token" => $user->createToken("API Token of " . $user->name)->plainTextToken,
                "message" => "User register successfully",
            ]);

        } catch (Exception $e) {
            return $this->error(
                "",
                500,
                $e
            );
        }
    }

    public function login($request)
    {
        try {
            
            if (!Auth::attempt($request->only(['email', 'password']))) {
                return $this->error('', 'Credential do not match', 401);
            };
            
            $user = User::where('email', $request->email)->first();
            $user->tokens()->delete();

            $accessTokenExpireAt = Carbon::now()->addHours(1);
            $refreshTokenExpireAt = Carbon::now()->addDays(7);

            $accessToken = $user->createToken("access_token", ["*"], $accessTokenExpireAt)->plainTextToken;
            $refreshToken = $user->createToken("refresh_token", ["refresh"], $refreshTokenExpireAt)->plainTextToken;

            return $this->success([
                'response' => [
                    "userId" => $user->id,
                    "accessToken" => $accessToken,
                    "accessTokenExpiresAt" => $accessTokenExpireAt,
                    "refreshToken" => $refreshToken,
                    "refreshTokenExpiresAt" => $refreshTokenExpireAt,
                ],
            ]);

        } catch (Exception $e) {
            return $this->error(
                "",
                500,
                $e
            );
        }
    }

    public function refreshToken($request) {
        $currentAccessToken = $request->bearerToken();
        $refreshToken = PersonalAccessToken::findToken($currentAccessToken);

        if(!$refreshToken || !$refreshToken->can('refresh') || $refreshToken->expire_at->isPast()) {
            return response()->json(["message" => "Invalid or expired token"], 401);
        }

        $user = $refreshToken->tokenable();
        $refreshToken->delete();

        $accessTokenExpiresAt = Carbon::now()->addHours(1);
        $refreshTokenExpiresAt = Carbon::now()->addDays(10);

        $newAccessToken = $user->createToken('access_token', ['*'], $accessTokenExpiresAt)->plainTextToken;
        $newRefreshToken = $user->createToken('refresh_token', ['refresh'], $refreshTokenExpiresAt)->plainTextToken;

        return $this->success([
            'response' => [
                "accessToken" => $newAccessToken,
                "accessTokenExpiresAt" => $accessTokenExpiresAt,
                "refreshToken" => $newRefreshToken,
                "refreshTokenExpiresAt" => $refreshTokenExpiresAt,
            ],
        ]);
    }

    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();

            if (!$googleUser->getEmail()) {
                return response()->json(['error' => 'Google account has no email associated'], 400);
            }
            $user = User::where('email', $googleUser->getEmail())->first();
            if (!$user) {
                $user = User::create([
                    'name' => $googleUser->getName(),
                    'email' => $googleUser->getEmail(),
                    'avatar' => $googleUser->getAvatar(),
                    'google_id' => $googleUser->getId(),
                ]);
            } else {
                $user->update(['google_id' => $googleUser->getId()]);
            }

            Auth::login($user);

            return response()->json([
                'user' => $user,
                'google_user' => $googleUser,
                'token' => $user->createToken('Api Token of ' . $user->name)->plainTextToken
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to authenticate with Google', 'message' => $e->getMessage()], 500);
        }
    }
    public function destroy()
    {
        try {
            $logout = Auth::user()->tokens()->delete();
            if (!$logout) {
                return $this->error(
                    "",
                    500,
                    "Failed to logout"
                );
            }
            return $this->success([
                "",
                "message" => "logout successfullty"
            ]);
        } catch (Exception $e) {
            return $this->error(
                "",
                500,
                $e
            );
        }
    }
}
