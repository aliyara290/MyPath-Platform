<?php

namespace App\Http\Requests\V1;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserProfileRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            "fullName" => ["string"],
            "email" => ["string", "email", "unique:users,email"],
            "avatar" => ["nullable", "mimes:jpg,png,jpeg,gif", "max:2048", "image"],
            "position" => ["string", "nullable"],
            "website" => ["string", "nullable"],
            "bio" => ["string", "max:255", "nullable"],
        ];
    }
}
