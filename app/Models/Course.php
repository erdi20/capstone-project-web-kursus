<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $table = 'courses';

    protected $fillable = [
        'name',
        'slug',
        'description',
        'short_description',
        'thumbnail',
        'price',
        'status',
        'enrollment_start',
        'enrollment_end',
        'created_by',
        'discount_price',
        'discount_end_date',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function materials()
    {
        return $this->hasMany(Material::class);
    }

    public function classes(): HasMany
    {
        return $this->hasMany(CourseClass::class, 'course_id');
    }

    // ---------
    public function scopeOpen($query)
    {
        return $query->where('status', 'open');
    }
}
