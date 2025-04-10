<?php

namespace App\Interfaces;

interface BadgeServiceInterface
{
    public function awardBadge(int $studentId, string $badgeType): bool;
    public function checkBadgeEligibility(int $studentId, string $badgeType): bool;
}
