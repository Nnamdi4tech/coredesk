<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SchoolClass extends Model
{
    protected $fillable = [
        'tenant_id',
        'name',
    ];

    public function students()
    {
        return $this->hasMany(Student::class, 'class_id');
    }
}