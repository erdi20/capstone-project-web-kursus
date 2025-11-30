<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Model;

class EssayAssignment extends Model
{
    protected $table = 'essay_assignments';

    protected $fillable = [
        'course_class_id',
        'title',
        'description',
        'due_date',
        'is_published',
        'allow_file_upload',
        'created_by',
    ];

    // Relasi ke kelas
    public function courseClass(): BelongsTo
    {
        return $this->belongsTo(CourseClass::class);
    }

    // Relasi ke pembuat (dosen)
    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    // Relasi ke pengumpulan (submission)
    public function submissions(): HasMany
    {
        return $this->hasMany(EssaySubmission::class);
    }

   
}
