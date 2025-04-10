<?php

namespace App\Models;

use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Video extends Model
{
    use HasUuid, SoftDeletes;


    protected $keyType = "string";
    public $incrementing = false;

    protected $fillable = [
        "title",
        "description",
        "url",
        "course_id",
    ];


    public function courses() {
        return $this->belongsTo(Course::class);
    }
}
