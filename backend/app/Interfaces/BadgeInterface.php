<?php

namespace App\Interfaces;

interface BadgeInterface
{
    public function getAllBadges(array $filters = []);
    public function getPaginatedBadges(int $perPage = 15, array $filters = []);
    public function findBadgeById(int $id);
    public function createBadge(array $data);
    public function updateBadge(int $id, array $data);
    public function deleteBadge(int $id);
    public function findUserById();
    public function getBadgesByStudent(int $studentId);
}
