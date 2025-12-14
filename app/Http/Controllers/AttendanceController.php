<?php

// app/Http/Controllers/AttendanceController.php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\ClassEnrollment;
use App\Models\ClassMaterial;
use App\Services\GradingService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AttendanceController extends Controller
{
    public function store(Request $request, string $classId)
    {
        $request->validate([
            'photo' => 'required|image|mimes:jpeg,png,jpg|max:2048',  // max 2MB
        ]);

        // ✅ Cari class_material hari ini yang materinya membutuhkan absen
        $todayMaterial = ClassMaterial::with('material')
            ->where('course_class_id', $classId)
            ->whereDate('schedule_date', now()->startOfDay())
            ->first();

        // ✅ Cek apakah materinya memerlukan absen
        if (!$todayMaterial || !$todayMaterial->material->is_attendance_required) {
            return response()->json(['error' => 'Tidak ada sesi absensi hari ini.'], 404);
        }

        // Cek apakah sudah absen
        if (Attendance::where('class_material_id', $todayMaterial->id)
                ->where('student_id', Auth::id())
                ->exists()) {
            return response()->json(['error' => 'Anda sudah absen hari ini.'], 400);
        }

        // Simpan foto
        $photoPath = $request->file('photo')->store('attendances', 'public');

        // Simpan absensi
        Attendance::create([
            'class_material_id' => $todayMaterial->id,
            'student_id' => Auth::id(),
            'photo_path' => $photoPath,
            'attended_at' => now(),
        ]);
        // update progress
        $enrollment = ClassEnrollment::where('class_id', $todayMaterial->course_class_id)
            ->where('student_id', Auth::id())
            ->first();

        if ($enrollment) {
            $enrollment->updateProgress();  // ← tambahkan ini
            app(GradingService::class)->updateEnrollmentGrade($enrollment);
        }

        return response()->json(['success' => true, 'message' => 'Absensi berhasil!']);
    }
}
