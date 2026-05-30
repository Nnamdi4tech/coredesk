<?php
// app/Models/LectureNote.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LectureNote extends Model
{
    protected $fillable = [
        'tenant_id',
        'teacher_id',
        'subject_id',
        'class_id',
        'title',
        'content',
        'file_path',
        'file_name',
        'file_type',
        'type',
        'status',
        'approved',
        'rejected',
        'rejection_reason',
        'approved_by',
        'approved_at',
    ];

    protected $casts = [
        'approved' => 'boolean',
        'rejected' => 'boolean',
        'approved_at' => 'datetime',
    ];

    // Relationships
    public function tenant()
    {
        return $this->belongsTo(Tenant::class);
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
        return $this->belongsTo(SchoolClass::class, 'class_id');
    }

    public function approvedBy()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    // Scopes
    public function scopeApproved($query)
    {
        return $query->where('approved', true);
    }

    public function scopePending($query)
    {
        return $query->where('approved', false)->where('rejected', false);
    }

    public function scopeRejected($query)
    {
        return $query->where('rejected', true);
    }
}