<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    // app/Http/Controllers/HomeController.php

    public function index()
    {
        $sliders = \App\Models\Slider::where('is_active', true)
            ->orderBy('order')
            ->take(5)
            ->get();

        $topRatedCourses = Course::query()
            // Kita gunakan relasi 'enrollments' (HasManyThrough)
            ->withAvg('enrollments as avg_rating', 'rating')
            ->withCount('enrollments as review_count')
            ->whereHas('enrollments')
            ->orderBy('avg_rating', 'desc')
            ->orderBy('review_count', 'desc')
            ->limit(6)
            ->get();  // Jangan batasi kolom dengan get(['id',...]) dulu untuk testing

        return view('dashboard', compact('sliders', 'topRatedCourses'));
    }
}
