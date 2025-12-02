<?php

namespace App\Http\Controllers;

use App\Models\ClassEnrollment;
use App\Models\Course;
use App\Models\CourseClass;
use App\Models\EssayAssignment;
use App\Models\EssaySubmission;
use App\Models\Material;
use App\Models\QuizAssignment;
use App\Models\QuizSubmission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CourseClassController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $enrolledClasses = Auth::user()
            ->enrollments()
            ->with('courseClass.course', 'courseClass.CreatedBy')  // eager load relasi agar efisien
            ->get()
            ->pluck('courseClass');  // ekstrak hanya CourseClass-nya

        return view('student.class.listclass', compact('enrolledClasses'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    // CourseClassController.php
    // public function show(string $id)
    // {
    //     $user = Auth::user();
    //     $class = CourseClass::with(['course', 'materialsFE'])  // ✅ eager load materials
    //         ->where('id', $id)
    //         ->firstOrFail();
    //     $enrollment = ClassEnrollment::where('student_id', $user->id)
    //         ->where('class_id', $class->id)
    //         ->first();
    //     if (!$enrollment) {
    //         abort(403, 'Anda tidak terdaftar di kelas ini.');
    //     }
    //     return view('student.class.class', compact('class', 'enrollment'));
    // }
    // ------------------- refactor 2
    // public function show(string $id)
    // {
    //     $user = Auth::user();
    //     $class = CourseClass::with('course', 'materials')->findOrFail($id);
    //     $enrollment = ClassEnrollment::where('student_id', $user->id)
    //         ->where('class_id', $id)
    //         ->firstOrFail();
    //     // Ambil semua essay assignments untuk kelas ini
    //     $essayAssignments = EssayAssignment::where('course_class_id', $id)
    //         ->where('is_published', true)
    //         ->orderBy('due_date', 'asc')
    //         ->get();
    //     // Ambil submission user (jika ada)
    //     $userSubmissions = EssaySubmission::where('student_id', $user->id)
    //         ->whereIn('essay_assignment_id', $essayAssignments->pluck('id'))
    //         ->pluck('essay_assignment_id')
    //         ->toArray();
    //     return view('student.class.class', compact(
    //         'class', 'enrollment', 'essayAssignments', 'userSubmissions'
    //     ));
    // }
    // ------------------- refactor 3
    public function show(string $classId)
    {
        $user = Auth::user();
        $class = CourseClass::with('course', 'materials')->findOrFail($classId);

        $enrollment = ClassEnrollment::where('student_id', $user->id)
            ->where('class_id', $classId)
            ->firstOrFail();
        // absen
        $today = now()->startOfDay();
        $todayMaterial = $class
            ->classMaterials()
            ->whereDate('schedule_date', $today)
            ->first();
        // Ambil Essay Assignments
        $essayAssignments = EssayAssignment::where('course_class_id', $classId)
            ->where('is_published', true)
            ->get()
            ->map(function ($item) {
                $item->type = 'essay';
                return $item;
            });

        // Ambil Quiz Assignments
        $quizAssignments = QuizAssignment::where('course_class_id', $classId)
            ->where('is_published', true)
            ->get()
            ->map(function ($item) {
                $item->type = 'quiz';
                return $item;
            });

        // Gabung dan urutkan berdasarkan due_date (opsional)
        $allAssignments = $essayAssignments
            ->merge($quizAssignments)
            ->sortBy('due_date');

        // Ambil submission IDs
        $userEssaySubmissions = EssaySubmission::where('student_id', $user->id)
            ->whereIn('essay_assignment_id', $essayAssignments->pluck('id'))
            ->pluck('essay_assignment_id')
            ->toArray();

        $userQuizSubmissions = QuizSubmission::where('student_id', $user->id)
            ->whereIn('quiz_assignment_id', $quizAssignments->pluck('id'))
            ->pluck('quiz_assignment_id')
            ->toArray();

        return view('student.class.class', compact(
            'class',
            'enrollment',
            'allAssignments',
            'userEssaySubmissions',
            'userQuizSubmissions',
            'todayMaterial'
        ));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    // -------------------
}
