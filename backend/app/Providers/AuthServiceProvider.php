<?php

namespace App\Providers;

use App\Models\Course;
use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{   
    public function register(): void
    {
        
    }

    public function boot(): void
    {
            Gate::define('edit-course', function(User $user, Course $course) {
                return $user->id === $course->teacher_id;
            });
    }
}
