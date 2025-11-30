<?php

namespace App\Http\Controllers;

use App\Models\ClassEnrollment;
use App\Models\EssayAssignment;
use App\Models\EssaySubmission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EssayController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('student.essay.index');
    }

    public function show(string $classId, string $assignmentId)
    {
        $user = Auth::user();

        // Validasi: user terdaftar di kelas?
        $enrollment = ClassEnrollment::where('student_id', $user->id)
            ->where('class_id', $classId)
            ->firstOrFail();

        // Ambil assignment
        $assignment = EssayAssignment::where('id', $assignmentId)
            ->where('course_class_id', $classId)
            ->where('is_published', true)
            ->firstOrFail();

        // Cek apakah sudah pernah submit
        $submission = EssaySubmission::where('essay_assignment_id', $assignmentId)
            ->where('student_id', $user->id)
            ->first();

        return view('student.essay.index', compact('assignment', 'submission', 'classId'));
    }

    public function submit(Request $request, string $classId, string $assignmentId)
    {
        $request->validate([
            'essay_answer' => 'required|string|max:10000',
            // 'file' => 'nullable|file|max:5120', // jika izinkan upload file
        ]);

        $user = Auth::user();

        // Pastikan assignment valid
        $assignment = EssayAssignment::where('id', $assignmentId)
            ->where('course_class_id', $classId)
            ->firstOrFail();

        // Simpan jawaban
        EssaySubmission::updateOrCreate(
            [
                'essay_assignment_id' => $assignmentId,
                'student_id' => $user->id,
            ],
            [
                'answer_text' => $request->essay_answer,
                'submitted_at' => now(),
                'is_graded' => false,
            ]
        );

        return redirect()->route('kelas', ['id' => $classId]);
    }
}
