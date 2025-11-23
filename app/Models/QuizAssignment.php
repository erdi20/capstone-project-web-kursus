<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Model;

class QuizAssignment extends Model
{
    protected $table = 'quiz_assignments';

    protected $fillable = [
        'course_class_id',
        'title',
        'description',
        'due_date',
        'duration_minutes',
        'is_published',
        'created_by',
    ];

    // Relasi ke kelas
    public function courseClass(): BelongsTo
    {
        return $this->belongsTo(CourseClass::class);
    }

    // Relasi ke pembuat (user)
    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    // Satu kuis punya banyak soal
    public function questions(): HasMany
    {
        return $this->hasMany(QuizQuestion::class);
    }

    // Satu kuis punya banyak submission (dari banyak mahasiswa)
    public function submissions(): HasMany
    {
        return $this->hasMany(QuizSubmission::class);
    }

    protected $titleAttribute = 'question_text_clean';

    // Accessor untuk judul bersih
    public function getQuestionTextCleanAttribute(): string
    {
        return strip_tags($this->question_text ?: 'Soal tanpa teks');
    }
}
