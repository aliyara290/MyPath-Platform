<?php

namespace App\Http\Requests\V1;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCourseRequest extends FormRequest
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
            "title" => ["required", "string"],
            "description" => ["required", "string", "string"],
            "content" => ["required", "string"],
            "tags" => ["required", "array"],
            "tags.*" => ["exists:tags,id"],
            "duration" => ["required"],
            "cover" => ["string"],
            "level" => ["required", "string"],
            "categoryId" => ["required", "string"],
            "teacherId" => ["required", "string"],
        ];
    }
}
