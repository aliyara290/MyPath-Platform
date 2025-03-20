<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Enrolments extends Model
{
    /** @use HasFactory<\Database\Factories\EnrolmentsFactory> */
    use HasFactory;

    protected $fillable = [
        "course_id",
        "user_id",
        "progress"
    ];

    public function users() {
        return $this->belongsToMany(User::class, "user_id");
    }

    public function courses() {
        return $this->belongsToMany(Course::class, "course_id");
    }
}
