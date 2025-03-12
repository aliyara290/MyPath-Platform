<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Resources\Json\ResourceCollection;

class CourseCollection extends ResourceCollection
{
    public function toArray($request)
    {
        return $this->collection->map(function ($course) {
            return [
                'id' => $course->id,
                'title' => $course->title,
                'children' => $course->children,
                'description' => $course->description,
                'content' => $course->content,
                'video' => $course->video,
                'cover' => $course->cover,
                'duration' => $course->duration,
                'level' => $course->level,
                'teacherId' => $course->teacherId,
                'categoryName' => $course->categoryName,
                'tag_names' => $course->tags->pluck('name')->toArray(),
                'createdAt' => $course->created_at
            ];
        });
    }
}