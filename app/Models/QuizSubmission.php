<?php

namespace App\Models;

use App\Models\QuizAssignment;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Model;

class QuizSubmission extends Model
{
    protected $table = 'quiz_submissions';

    protected $fillable = [
        'quiz_assignment_id',
        'student_id',
        'started_at',
        'submitted_at',
        'is_graded',
        'score',
        'feedback',
    ];

    // Submission ini milik kuis tertentu
    public function quizAssignment(): BelongsTo
    {
        return $this->belongsTo(QuizAssignment::class);
    }

    // Submission ini dibuat oleh mahasiswa (user)
    public function student(): BelongsTo
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    // Satu submission berisi banyak jawaban (per soal)
    public function answers(): HasMany
    {
        return $this->hasMany(QuizAnswer::class);
    }
}
