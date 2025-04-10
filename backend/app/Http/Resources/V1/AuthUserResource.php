<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AuthUserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id" => $this->id,
            "fullName" => $this->name,
            "email" => $this->email,
            "avatar" => $this->avatar,
            "position" => $this->position,
            "website" => $this->website,
            "bio" => $this->bio,
            "joined" => $this->created_at,
        ];
    }
}
