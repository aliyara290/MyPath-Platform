<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CourseResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'content' => $this->content,
            'video' => $this->video,
            'cover' => $this->cover,
            'duration' => $this->duration,
            'level' => $this->level,
            'teacherId' => $this->teacher_id,
            'categoryName' => $this->category_name,
            'tags' => $this->tags,
            "createdAt" => $this->created_at,
        ];
    }
}
