<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Attendance extends Model
{
    protected $fillable = [
        'tenant_id',
        'student_id',
        'teacher_id',
        'class_id',
        'subject_id',
        'term',
        'session',
        'score',
        'rating',
        'remarks',
    ];
    
    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }
    
    public function teacher(): BelongsTo
    {
        return $this->belongsTo(Teacher::class);
    }
    
    public function class(): BelongsTo
    {
        return $this->belongsTo(SchoolClass::class);
    }
    
    public function subject(): BelongsTo
    {
        return $this->belongsTo(Subject::class);
    }
    
    // Helper method to get rating based on score
    public static function getRating($score)
    {
        if ($score >= 9 && $score <= 10) return 'Excellent';
        if ($score >= 7 && $score <= 8) return 'Very Good';
        if ($score >= 5 && $score <= 6) return 'Good';
        if ($score >= 3 && $score <= 4) return 'Fair';
        return 'N/A';
    }
    
    // Helper method to get color class for rating
    public static function getRatingColor($rating)
    {
        return match($rating) {
            'Excellent' => 'bg-emerald-50 text-emerald-600',
            'Very Good' => 'bg-blue-50 text-blue-600',
            'Good'      => 'bg-green-50 text-green-600',
            'Fair'      => 'bg-yellow-50 text-yellow-600',
            default     => 'bg-gray-50 text-gray-600',
        };
    }
}