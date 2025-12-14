<?php

namespace App\Providers;

use App\Models\CourseClass;
use App\Observers\CourseClassObserver;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        CourseClass::observe(CourseClassObserver::class);
    }
}
