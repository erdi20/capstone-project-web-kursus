<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $table = 'courses';

    protected $fillable = [
        'name',
        'description',
        'thumbnail',
        'price',
        'status',
        'enrollment_start',
        'enrollment_end',
        'created_by',
    ];

    public function CreatedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function materials()
    {
        return $this->hasMany(Material::class);
    }
}
