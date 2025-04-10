<?php
namespace App\Policies;

use App\Models\Course;
use App\Models\User;

class CoursePolicy
{
    public function viewAny(User $user): bool
    {
        return false;
    }

    public function view(User $user, Course $course): bool
    {
        return false;
    }

    public function create(User $user): bool
    {
        return $user->role === "teacher";
    }

    public function update(User $user, Course $course): bool
    {
        return $user->id === $course->teacher_id;
    }

    public function delete(User $user, Course $course): bool
    {
        return $user->id === $course->user_id || $user->role === "admin";
    }

    public function restore(User $user, Course $course): bool
    {
        return false;
    }

    public function forceDelete(User $user, Course $course): bool
    {
        return false;
    }
}