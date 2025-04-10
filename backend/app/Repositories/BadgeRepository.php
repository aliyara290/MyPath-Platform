<?php

namespace App\Repositories;

use App\Interfaces\BadgeInterface;
use App\Models\Badge;
use App\Models\User;
use App\Traits\HttpResponses;
use Exception;
use Illuminate\Support\Facades\Auth;

class BadgeRepository implements BadgeInterface
{
    protected $model;

    public function __construct(Badge $badge)
    {
        $this->model = $badge;
    }

    public function getAllBadges(array $filters = [])
    {
        $query = $this->model->newQuery();

        // Apply filters
        if (!empty($filters['type'])) {
            $query->where('type', $filters['type']);
        }

        if (isset($filters['is_active'])) {
            $query->where('is_active', $filters['is_active']);
        }

        return $query->get();
    }

    public function getPaginatedBadges(int $perPage = 15, array $filters = [])
    {
        $query = $this->model->newQuery();

        // Apply filters
        if (!empty($filters['type'])) {
            $query->where('type', $filters['type']);
        }

        if (isset($filters['is_active'])) {
            $query->where('is_active', $filters['is_active']);
        }

        return $query->paginate($perPage);
    }

    public function findBadgeById(int $id)
    {
        return $this->model->findOrFail($id);
    }

    public function createBadge(array $data)
    {
        return $this->model->create($data);
    }

    public function updateBadge(int $id, array $data)
    {
        $badge = $this->findBadgeById($id);
        $badge->update($data);
        return $badge;
    }

    public function deleteBadge(int $id): bool
    {
        return $this->findBadgeById($id)->delete();
    }

    public function getBadgesByStudent(int $studentId)
    {
        return $this->model->whereHas('students', function ($query) use ($studentId) {
            $query->where('student_id', $studentId);
        })->get();
    }
    public function findUserById()
    {
        $userId = Auth::user();
        $user = User::find($userId->id)->first();

        return $user;
    }
}
