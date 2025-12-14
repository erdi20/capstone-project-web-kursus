<?php

namespace App\Http\Controllers;

use App\Models\ClassEnrollment;
use App\Models\CourseClass;
use App\Models\EssaySubmission;
use App\Models\Material;
use App\Models\QuizSubmission;
use App\Services\MaterialCompletionService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MaterialController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
    // public function show(string $classId, string $materialId)
    // {
    //     $user = Auth::user();
    //     $enrollment = ClassEnrollment::where('student_id', $user->id)
    //         ->where('class_id', $classId)
    //         ->firstOrFail();
    //     $class = CourseClass::with('course')->findOrFail($classId);
    //     // ✅ Hapus filter course_class_id
    //     $material = Material::with([
    //         'essayAssignments' => fn($q) => $q->where('is_published', true),
    //         'quizAssignments' => fn($q) => $q->where('is_published', true),
    //     ])->findOrFail($materialId);
    //     // Validasi materi ada di kelas
    //     $isMaterialInClass = $class->materials()->where('materials.id', $materialId)->exists();
    //     if (!$isMaterialInClass) {
    //         abort(403);
    //     }
    //     // Ambil submission user
    //     $userEssaySubmissions = EssaySubmission::where('student_id', $user->id)
    //         ->whereIn('essay_assignment_id', $material->essayAssignments->pluck('id'))
    //         ->pluck('essay_assignment_id')
    //         ->toArray();
    //     $userQuizSubmissions = QuizSubmission::where('student_id', $user->id)
    //         ->whereIn('quiz_assignment_id', $material->quizAssignments->pluck('id'))
    //         ->pluck('quiz_assignment_id')
    //         ->toArray();
    //     $today = now()->startOfDay();
    //     $todayMaterial = $class
    //         ->classMaterials()
    //         ->with('material')
    //         ->get()
    //         ->first(function ($cm) {
    //             return $cm->schedule_date &&
    //                 \Carbon\Carbon::parse($cm->schedule_date)->startOfDay()->isSameDay(now()->startOfDay());
    //         });
    //     $hasAttended = $todayMaterial && $todayMaterial->attendances()->where('student_id', Auth::id())->exists();
    //     app(MaterialCompletionService::class)->checkAndMarkAsCompleted(Auth::id(), $classId, $materialId);
    //     return view('student.material.materi', compact(
    //         'class', 'material', 'enrollment', 'userEssaySubmissions', 'userQuizSubmissions', 'todayMaterial', 'hasAttended'
    //     ));
    // }
    public function show(string $classId, string $materialId)
    {
        $user = Auth::user();

        // Validasi: user terdaftar di kelas
        $enrollment = ClassEnrollment::where('student_id', $user->id)
            ->where('class_id', $classId)
            ->firstOrFail();

        // Load kelas dengan relasi yang dibutuhkan
        $class = CourseClass::with([
            'course',
            'classMaterials.material'  // penting untuk sidebar & absensi
        ])->findOrFail($classId);

        // Ambil materi dengan tugas
        $material = Material::with([
            'essayAssignments' => fn($q) => $q->where('is_published', true),
            'quizAssignments' => fn($q) => $q->where('is_published', true),
        ])->findOrFail($materialId);

        // Validasi: materi ada di kelas
        $isMaterialInClass = $class->materials()->where('materials.id', $materialId)->exists();
        if (!$isMaterialInClass) {
            abort(403);
        }

        // Ambil submission user untuk tugas di materi ini
        $userEssaySubmissions = EssaySubmission::where('student_id', $user->id)
            ->whereIn('essay_assignment_id', $material->essayAssignments->pluck('id'))
            ->pluck('essay_assignment_id')
            ->toArray();

        $userQuizSubmissions = QuizSubmission::where('student_id', $user->id)
            ->whereIn('quiz_assignment_id', $material->quizAssignments->pluck('id'))
            ->pluck('quiz_assignment_id')
            ->toArray();

        // === LOGIKA ABSENSI: HANYA UNTUK MATERI INI ===
        $isCurrentMaterialForAttendance = false;
        $hasAttended = false;

        // Cari sesi absen hari ini
        $todayClassMaterial = $class
            ->classMaterials
            ->first(function ($cm) {
                return $cm->schedule_date &&
                    \Carbon\Carbon::parse($cm->schedule_date)->startOfDay()->isSameDay(now()->startOfDay());
            });

        // Jika ada sesi hari ini & materi ini adalah sesinya & memerlukan absen
        if ($todayClassMaterial &&
                $todayClassMaterial->material_id == $materialId &&
                $todayClassMaterial->material->is_attendance_required) {
            $isCurrentMaterialForAttendance = true;
            $hasAttended = $todayClassMaterial
                ->attendances()
                ->where('student_id', Auth::id())
                ->exists();
        }

        // Tandai materi sebagai selesai jika semua tugas dikumpulkan
        app(\App\Services\MaterialCompletionService::class)
            ->checkAndMarkAsCompleted(Auth::id(), $classId, $materialId);

        return view('student.material.materi', compact(
            'class',
            'material',
            'enrollment',
            'userEssaySubmissions',
            'userQuizSubmissions',
            'isCurrentMaterialForAttendance',  // ✅ untuk absensi spesifik
            'hasAttended'  // ✅ status absen
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
}
