<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Result extends Model
{
    protected $fillable = [
        'tenant_id',
        'teacher_id',
        'student_id',
        'subject_id',
        'class_id',
        'ca1',
        'ca2',
        'ca3',
        'exam',
        'total',
        'average',
        'grade',
        'remark',
        'position',
        'submitted',
        'term',
        'session',  // ✅ ADD THIS
    ];

    protected $casts = [
       'submitted' => 'boolean',
     ];

    // 🔗 RELATIONSHIPS

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    public function class()
    {
      return $this->belongsTo(ClassModel::class);
    }
 public function schoolClass()
{
    return $this->belongsTo(\App\Models\SchoolClass::class, 'class_id');
}

}