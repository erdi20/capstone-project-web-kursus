<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;

class Material extends Model
{
    protected $table = 'materials';

    protected $fillable = [
        'name',
        'content',
        'link_video',
        'image',
        'pdf',
        'course_id',
        'created_by',
        'is_attendance_required',
    ];

    public function Course(): BelongsTo
    {
        return $this->belongsTo(Course::class, 'course_id');
    }

    public function CreatedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function essayAssignments()
    {
        return $this->hasMany(EssayAssignment::class, 'material_id');
    }

    public function classMaterials()
    {
        return $this->hasMany(ClassMaterial::class, 'material_id');
    }

    public function quizAssignments()
    {
        return $this->hasMany(QuizAssignment::class, 'material_id');
    }

    protected $casts = [
        'is_attendance_required' => 'boolean',
    ];
}
