<?php

namespace App\Http\Controllers;

use App\Models\ClassEnrollment;
use App\Models\CourseClass;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CertificateController extends Controller
{
    public function download(string $classId)
    {
        $enrollment = ClassEnrollment::where('class_id', $classId)
            ->where('student_id', Auth::id())
            ->where('status', 'completed')
            ->firstOrFail();

        $class = CourseClass::with('course')->findOrFail($classId);
        $student = Auth::user();

        $pdf = Pdf::loadView('certificates.default', [
            'student' => $student,
            'course' => $class->course,
            'class' => $class,
            'enrollment' => $enrollment,
        ])->setPaper('A4');

        return $pdf->download('sertifikat.pdf');
    }
}
