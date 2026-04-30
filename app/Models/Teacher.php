<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    protected $fillable = [
        'tenant_id',
        'user_id',
        'name',
    'email',
    'phone',
    'gender',
    'dob',
    'address',

    'employee_id',
    'staff_id',
    'employment_date',
    'employment_type',
    'department',
    'position',
    'status',
    'subject',
    'plain_password',

        
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

//     public function students()
// {
//     return $this->hasMany(Student::class);
// }

public function subjects()
{
    return $this->belongsToMany(Subject::class, 'teacher_subjects')
        ->withPivot('class_id');
}

/**
 * Get all classes assigned to this teacher through students
 */


/**
 * Get all students assigned to this teacher
 */
public function students()
{
    return $this->hasMany(Student::class, 'teacher_id');
}

/**
 * Get unique classes assigned to this teacher through students
 */
public function getAssignedClassesAttribute()
{
    return $this->students()
        ->with('schoolClass')
        ->get()
        ->pluck('schoolClass.name')
        ->unique()
        ->filter()
        ->implode(', ');
}


}