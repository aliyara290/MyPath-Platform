<?php

namespace App\Models;

use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Course extends Model
{
    /** @use HasFactory<\Database\Factories\V1\CourseFactory> */
    use HasFactory, HasUuid, SoftDeletes;

    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        "title",
        "description",
        "content",
        "video",
        "cover",
        "duration",
        "level",
        // "teacher_id",
        "category_id",
    ];

    public function tags(): BelongsToMany {
        return $this->belongsToMany(Tag::class);
    }
}
