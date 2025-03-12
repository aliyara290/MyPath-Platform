<?php

namespace App\Providers;

use App\Interfaces\CategoryInterface;
use App\Interfaces\CourseInterface;
use App\Interfaces\TagInterface;
use App\Repositories\CategoryRepository;
use App\Repositories\CourseRepository;
use App\Repositories\TagRepository;
use Illuminate\Support\ServiceProvider;

/**
 * @OA\Info(
 * title="E-Learning",
 * version="1.0.0"    
 * )
 */

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(CategoryInterface::class, CategoryRepository::class);
        $this->app->bind(CourseInterface::class, CourseRepository::class);
        $this->app->bind(TagInterface::class, TagRepository::class);
    }

    
    public function boot(): void
    {
        //
    }
}
