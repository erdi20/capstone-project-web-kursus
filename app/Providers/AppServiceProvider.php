<?php

namespace App\Providers;

use App\Http\Livewire\DeleteUser;
use App\Models\CourseClass;
use App\Observers\CourseClassObserver;
use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;
use App\Models\Setting;
use Illuminate\Support\Facades\View;
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
        View::composer('*', function ($view) {
            $view->with('siteSettings', Setting::first());
        });
    }
}
