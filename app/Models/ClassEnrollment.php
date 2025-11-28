<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClassEnrollment extends Model
{
    protected $table = 'class_enrollments';

    protected $fillable = [
        'class_id',
        'student_id',
        'enrolled_at',
        'progress_percentage',
        'completed_at',
        'status',
        'grade',
        'certificate',
        'issued_at',
        'is_verified',
        'review',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'student_id');  // foreign key = student_id
    }

    public function course()
    {
        return $this->belongsTo(Course::class, 'class_id');  // foreign key = class_id
    }
    
}
