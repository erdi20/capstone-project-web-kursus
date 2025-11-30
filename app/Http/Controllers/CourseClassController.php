<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Material;
use App\Models\CourseClass;
use Illuminate\Http\Request;
use App\Models\ClassEnrollment;
use App\Models\EssayAssignment;
use App\Models\EssaySubmission;
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
    // ------------------- refactor
    public function show(string $id)
    {
        $user = Auth::user();
        $class = CourseClass::with('course', 'materials')->findOrFail($id);

        $enrollment = ClassEnrollment::where('student_id', $user->id)
            ->where('class_id', $id)
            ->firstOrFail();

        // Ambil semua essay assignments untuk kelas ini
        $essayAssignments = EssayAssignment::where('course_class_id', $id)
            ->where('is_published', true)
            ->orderBy('due_date', 'asc')
            ->get();

        // Ambil submission user (jika ada)
        $userSubmissions = EssaySubmission::where('student_id', $user->id)
            ->whereIn('essay_assignment_id', $essayAssignments->pluck('id'))
            ->pluck('essay_assignment_id')
            ->toArray();

        return view('student.class.class', compact(
            'class', 'enrollment', 'essayAssignments', 'userSubmissions'
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
