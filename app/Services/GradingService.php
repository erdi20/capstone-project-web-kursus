<?php

namespace App\Services;

use App\Models\Attendance;
use App\Models\ClassEnrollment;
use App\Models\ClassMaterial;
use App\Models\CourseClass;
use App\Models\EssaySubmission;
use App\Models\QuizSubmission;

class GradingService
{
    public function calculateFinalScore(CourseClass $class, int $studentId): array
    {
        // Hitung rata-rata nilai Essay
        $essayAvg = EssaySubmission::whereHas('assignment.material.classMaterials', function ($q) use ($class) {
            $q->where('course_class_id', $class->id);
        })
            ->where('student_id', $studentId)
            ->where('is_graded', true)
            ->avg('score') ?? 0;

        // Hitung rata-rata nilai Quiz
        $quizAvg = QuizSubmission::whereHas('assignment.material.classMaterials', function ($q) use ($class) {
            $q->where('course_class_id', $class->id);
        })
            ->where('student_id', $studentId)
            ->where('is_graded', true)
            ->avg('score') ?? 0;

        // Hitung persentase kehadiran
        $totalMeetings = ClassMaterial::where('course_class_id', $class->id)->count();
        $attended = Attendance::whereHas('classMaterial', fn($q) => $q->where('course_class_id', $class->id))
            ->where('student_id', $studentId)
            ->count();

        $attendancePercentage = $totalMeetings > 0 ? ($attended / $totalMeetings) * 100 : 0;

        // Hitung nilai akhir (skala 0-100)
        $finalScore = (
            ($essayAvg * $class->course->essay_weight)
            + ($quizAvg * $class->course->quiz_weight)
            + ($attendancePercentage * $class->course->attendance_weight)
        ) / 100;

        $finalScore = min(100, max(0, round($finalScore, 0)));

        // Tentukan apakah memenuhi syarat kelulusan
        $meetsAttendance = $attendancePercentage >= $class->min_attendance_percentage;
        $meetsScore = $finalScore >= $class->min_final_score;
        $isPassed = $meetsAttendance && $meetsScore;

        return [
            'essay_avg' => $essayAvg,
            'quiz_avg' => $quizAvg,
            'attendance_percentage' => $attendancePercentage,
            'final_score' => $finalScore,
            'is_passed' => $isPassed,
        ];
    }

    public function updateEnrollmentGrade(ClassEnrollment $enrollment): void
    {
        $class = $enrollment->courseClass;
        $studentId = $enrollment->student_id;

        $result = $this->calculateFinalScore($class, $studentId);

        $enrollment->update([
            'grade' => $result['final_score'],
            'status' => $result['is_passed'] ? 'completed' : 'active',
            'completed_at' => $result['is_passed'] ? now() : null,
        ]);
    }
}
