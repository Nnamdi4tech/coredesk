<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $fillable = [
        'tenant_id',
        'class_id',
        'teacher_id',
        'name',
        'email',
        'phone',
        'gender',
        'class',
        'password',
        'student_id',
        'plain_password',
        
    ];

    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }



public function schoolClass()
{
    return $this->belongsTo(\App\Models\SchoolClass::class, 'class_id');
}



    


}