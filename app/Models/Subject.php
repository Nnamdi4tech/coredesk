<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    protected $fillable = [
        'tenant_id',
        // 'teacher_id',
        'name',
        'course_code',
        'description',
        'topic',
        
    ];

    public function teachers()
{
    return $this->belongsToMany(Teacher::class, 'teacher_subjects')
        ->withPivot('class_id');
}






}