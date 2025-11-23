<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;

class EssaySubmission extends Model
{
    protected $table = 'essay_submissions';

    protected $fillable = [
        'essay_assignment_id',
        'student_id',
        'answer_text',
        'file_path',
        'submitted_at',
        'is_graded',
        'score',
        'feedback',
    ];

    public function assignment(): BelongsTo
    {
        return $this->belongsTo(EssayAssignment::class, 'essay_assignment_id');
    }

    // Relasi ke mahasiswa
    public function student(): BelongsTo
    {
        return $this->belongsTo(User::class, 'student_id');
    }
}
