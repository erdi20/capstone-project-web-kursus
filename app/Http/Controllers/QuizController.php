<?php

namespace App\Http\Controllers;

use App\Models\QuizAnswer;
use App\Models\QuizQuestion;
use Illuminate\Http\Request;
use App\Models\QuizAssignment;
use App\Models\QuizSubmission;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class QuizController extends Controller
{
    // QuizController.php
    public function show(string $classId, string $assignmentId)
    {
        $user = Auth::user();
        $assignment = QuizAssignment::where('id', $assignmentId)
            ->where('course_class_id', $classId)
            ->firstOrFail();

        $questions = $assignment->questions;  // pastikan relasi 'questions' ada di model
        $submission = QuizSubmission::where('quiz_assignment_id', $assignmentId)
            ->where('student_id', $user->id)
            ->first();

        return view('student.quiz.quiz', compact('assignment', 'questions', 'submission', 'classId'));
    }

    // public function submit(Request $request, string $classId, string $assignmentId)
    // {
    //     $user = Auth::user();
    //     $assignment = QuizAssignment::with('questions')->findOrFail($assignmentId);

    //     // Validasi: pastikan semua soal dijawab
    //     $questions = $assignment->questions;
    //     foreach ($questions as $q) {
    //         if (!$request->has("question_{$q->id}")) {
    //             return back()->withErrors(['message' => 'Harap jawab semua soal.']);
    //         }
    //     }

    //     // Mulai transaksi database
    //     DB::beginTransaction();
    //     try {
    //         // Buat submission
    //         $submission = QuizSubmission::create([
    //             'quiz_assignment_id' => $assignmentId,
    //             'student_id' => $user->id,
    //             'started_at' => now(),  // atau simpan saat mulai, jika perlu
    //             'submitted_at' => now(),
    //             'is_graded' => true,  // langsung dinilai otomatis
    //         ]);

    //         $totalScore = 0;
    //         $answers = [];

    //         foreach ($questions as $question) {
    //             $selected = $request->input("question_{$question->id}");
    //             $isCorrect = $selected === $question->correct_option;
    //             $score = $isCorrect ? $question->points : 0;

    //             if ($isCorrect) {
    //                 $totalScore += $score;
    //             }

    //             // Simpan jawaban
    //             QuizAnswer::create([
    //                 'quiz_submission_id' => $submission->id,
    //                 'quiz_question_id' => $question->id,
    //                 'selected_option' => $selected,
    //                 'is_correct' => $isCorrect,
    //             ]);

    //             // Simpan untuk ditampilkan di result
    //             $answers[] = [
    //                 'question' => $question->question_text,
    //                 'selected' => $selected,
    //                 'is_correct' => $isCorrect,
    //             ];
    //         }

    //         // Update skor akhir
    //         $submission->update(['score' => $totalScore]);

    //         // Simpan ke session untuk ditampilkan di halaman hasil
    //         session(['quiz_result' => [
    //             'assignment_title' => $assignment->title,
    //             'score' => $totalScore,
    //             'total_questions' => $questions->count(),
    //             'answers' => $answers,
    //         ]]);

    //         DB::commit();

    //         return redirect()->route('quiz.result', ['classId' => $classId, 'assignmentId' => $assignmentId]);
    //     } catch (\Exception $e) {
    //         DB::rollBack();
    //         return back()->withErrors(['message' => 'Terjadi kesalahan saat menyimpan jawaban.']);
    //     }
    // }

    // public function result(string $classId, string $assignmentId)
    // {
    //     $result = session('quiz_result');
    //     if (!$result) {
    //         return redirect()->route('quiz.show', ['classId' => $classId, 'assignmentId' => $assignmentId]);
    //     }

    //     return view('student.quiz.hasilquiz', compact('result', 'classId', 'assignmentId'));
    // }

    // -------
    public function submit(Request $request, string $classId, string $assignmentId)
    {
        $user = Auth::user();

        // Validasi assignment
        $assignment = QuizAssignment::where('id', $assignmentId)
            ->where('course_class_id', $classId)
            ->firstOrFail();

        // Ambil semua soal untuk assignment ini
        $questions = QuizQuestion::where('quiz_assignment_id', $assignmentId)->get();

        // Validasi: pastikan semua soal dijawab
        $answers = [];
        $totalScore = 0;
        $maxPossibleScore = 0;

        foreach ($questions as $question) {
            $answerKey = 'question_' . $question->id;
            $selected = $request->input($answerKey);

            if ($selected === null) {
                return back()->withErrors(['question_' . $question->id => 'Harap jawab semua soal.']);
            }

            // Cek kebenaran
            $isCorrect = $selected === $question->correct_option;
            $score = $isCorrect ? $question->points : 0;

            $answers[] = [
                'quiz_question_id' => $question->id,
                'selected_option' => $selected,
                'is_correct' => $isCorrect,
            ];

            $totalScore += $score;
            $maxPossibleScore += $question->points;
        }

        // Simpan submission
        $submission = QuizSubmission::updateOrCreate(
            [
                'quiz_assignment_id' => $assignmentId,
                'student_id' => $user->id,
            ],
            [
                'started_at' => now(),  // atau simpan saat mulai jika ada halaman khusus
                'submitted_at' => now(),
                'is_graded' => true,
                'score' => $totalScore,
            ]
        );

        // Simpan jawaban per soal
        foreach ($answers as $ans) {
            $ans['quiz_submission_id'] = $submission->id;
            QuizAnswer::updateOrCreate(
                [
                    'quiz_submission_id' => $submission->id,
                    'quiz_question_id' => $ans['quiz_question_id'],
                ],
                $ans
            );
        }

        // Redirect ke halaman hasil
        return redirect()->route('quiz.result', [
            'classId' => $classId,
            'assignmentId' => $assignmentId
        ])->with('success', 'Quiz berhasil dikirim!');
    }
    public function result(string $classId, string $assignmentId)
{
    $user = Auth::user();

    $assignment = QuizAssignment::with('questions')->findOrFail($assignmentId);
    $submission = QuizSubmission::where('quiz_assignment_id', $assignmentId)
        ->where('student_id', $user->id)
        ->firstOrFail();

    // Ambil jawaban siswa dengan relasi ke soal
    $answers = QuizAnswer::with('question')
        ->where('quiz_submission_id', $submission->id)
        ->get();

    return view('student.quiz.hasilquiz', compact('assignment', 'submission', 'answers'));
}
}
