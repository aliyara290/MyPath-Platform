<?php

namespace App\Models;

use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasUuid, HasApiTokens;

    protected $keyType = "string";
    public $incrementing = false;

    protected $fillable = [
        'name',
        'email',
        'password',
        'google_id',
        'avatar',
        'role',
        'position',
        'website',
        'bio',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
 
    public function courses()
    {
        return $this->hasMany(Course::class);
    }
    
    public function enrolledCourses()
    {
        return $this->belongsToMany(Course::class, 'course_user', 'student_id', 'course_id');
    }
     
    public function isStudent()
    {
        return $this->role === 'student';
    }
     
    public function isTeacher()
    {
        return $this->role === 'teacher';
    }

    public function users() {
        return $this->belongsToMany(User::class, "user_id");
    }
}
