<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Model;

class CourseClass extends Model
{
    protected $table = 'course_classes';

    protected $fillable = [
        'name',
        'description',
        'course_id',
        'created_by',
        'status',
        'max_quota',
    ];

    // public function Course(): BelongsTo
    // {
    //     return $this->belongsTo(Course::class, 'course_id');
    // }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function CreatedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function courseClasses()
    {
        return $this
            ->belongsToMany(CourseClass::class, 'class_materials')
            ->withPivot('order', 'schedule_date', 'visibility');
    }

    public function materials(): BelongsToMany
    {
        return $this
            ->belongsToMany(Material::class, 'class_materials', 'course_class_id', 'material_id')
            ->withPivot(['order', 'schedule_date', 'visibility'])  // Kolom tambahan dari pivot
            ->withTimestamps()  // Jika kamu menggunakan created_at/updated_at di pivot
            ->orderBy('class_materials.order');  // <-- INI YANG DITAMBAHKAN
    }
}
