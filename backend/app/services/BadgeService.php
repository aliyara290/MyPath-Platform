<?php

namespace App\Services;

use App\Interfaces\BadgeInterface;
use App\Interfaces\BadgeServiceInterface;
use App\Repositories\BadgeRepository;
use Carbon\Carbon;

class BadgeService implements BadgeServiceInterface
{
    protected $badgeRepository;

    public function __construct(
        BadgeInterface $badgeRepository
    ) {
        $this->badgeRepository = $badgeRepository;
    }

    public function awardBadge(int $studentId, string $badgeType): bool
    {
        if (!$this->checkBadgeEligibility($studentId, $badgeType)) {
            return false;
        }

        $badge = $this->badgeRepository->getAllBadges(['type' => $badgeType, 'is_active' => true])->first();

        if (!$badge) {
            return false;
        }

        $student = $this->badgeRepository->findUserById($studentId);
        $student->badges()->attach($badge->id, ['earned_at' => now()]);

        return true;
    }

    public function checkBadgeEligibility(int $studentId, string $badgeType): bool
    {
        $student = $this->badgeRepository->findUserById($studentId);

        switch ($badgeType) {
            case 'COURSE_COMPLETION':
                return $student->courses()->where('progress', 100)->count() > 0;
            
            case 'MULTIPLE_COURSES':
                return $student->courses()->count() >= 10;
            
            case 'COURSE_COUNT':
                return $student->courses()->count() >= 5;
            
            case 'PLATFORM_ENGAGEMENT':
                return $student->created_at->diffInMonths(now()) >= 6;
            
            case 'MENTOR_COURSES':
                return $student->courses()->groupBy('mentor_id')->count() >= 2;
            
            case 'PROFILE_COMPLETION':
                return $this->isProfileComplete($student);

            default:
                return false;
        }
    }

    private function isProfileComplete($student): bool
    {
        return $student->name && 
               $student->email && 
               $student->profile_picture && 
               $student->bio && 
               $student->interests;
    }
}