<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClassMaterial extends Model
{
    protected $table = 'class_materials';

    protected $fillable = [
        'course_class_id',
        'material_id',
        'order',
        'schedule_date',
        'visibility',
    ];
}
