<?php

namespace App\Providers;

use App\Interfaces\Auth\AuthInterface;
use App\Interfaces\CategoryInterface;
use App\Interfaces\CourseInterface;
use App\Interfaces\EnrolmentsInterface;
use App\Interfaces\TagInterface;
use App\Interfaces\UserProfileInterface;
use App\Interfaces\VideoInterface;
use App\Repositories\Auth\AuthRepository;
use App\Repositories\CategoryRepository;
use App\Repositories\CourseRepository;
use App\Repositories\EnrolmentsRepository;
use App\Repositories\TagRepository;
use App\Repositories\UserProfileRepository;
use App\Repositories\VideoRepository;
use Illuminate\Support\ServiceProvider;

/**
 * @OA\Info(
 * title="E-Learning",
 * version="1.0.0"    
 * )
 */

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(EnrolmentsInterface::class, EnrolmentsRepository::class);
        $this->app->bind(CategoryInterface::class, CategoryRepository::class);
        $this->app->bind(UserProfileInterface::class, UserProfileRepository::class);
        $this->app->bind(AuthInterface::class, AuthRepository::class);
        $this->app->bind(CourseInterface::class, CourseRepository::class);
        $this->app->bind(TagInterface::class, TagRepository::class);
        $this->app->bind(VideoInterface::class, VideoRepository::class);
    }

    public function boot(): void
    {
        //
    }
}
