<?php

namespace App\Http\Controllers;

use App\Models\ClassEnrollment;
use App\Models\Course;
use App\Models\CourseClass;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Midtrans\Config;
use Midtrans\Snap;

class CourseController extends Controller
{
    public function index()
    {
        $courses = Course::Open()->with('user')->get();
        return view('student.course.listcourse', \compact('courses'));
    }

    public function show($slug)
    {
        $course = Course::where('slug', $slug)
            ->with([
                'user',
                'classes' => fn($query) => $query->where('status', 'open')
            ])
            ->firstOrFail();

        return view('student.course.course', compact('course'));
    }
}
