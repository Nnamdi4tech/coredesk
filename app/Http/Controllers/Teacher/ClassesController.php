<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Teacher;
use App\Models\Student;
use App\Models\SchoolClass;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ClassesController extends Controller
{
    public function index($subdomain)
    {
        $teacherId = Auth::user()->teacher->id ?? null;
        $tenantId = Auth::user()->tenant_id;
        
        if (!$teacherId) {
            return view('teacher.classes.index', compact('subdomain'))->with('error', 'Teacher profile not found.');
        }
        
        // Get all students assigned to this teacher
        $students = Student::where('tenant_id', $tenantId)
                           ->where('teacher_id', $teacherId)
                           ->with('schoolClass')
                           ->get();
        
        // Get unique classes from students
        $classes = $students->pluck('schoolClass')
                            ->unique('id')
                            ->filter();
        
        // Get all classes for filter dropdown
        $allClasses = SchoolClass::where('tenant_id', $tenantId)->get();
        
        // CARD 1: Total Classes
        $totalClasses = $classes->count();
        
        // CARD 2: Total Students
        $totalStudents = $students->count();
        
        // CARD 3: Male Students
        $maleStudents = $students->where('gender', 'male')->count();
        
        // CARD 4: Female Students
        $femaleStudents = $students->where('gender', 'female')->count();
        
        // Calculate percentages
        $malePercentage = $totalStudents > 0 ? round(($maleStudents / $totalStudents) * 100) : 0;
        $femalePercentage = $totalStudents > 0 ? round(($femaleStudents / $totalStudents) * 100) : 0;
        
        return view('teacher.classes.index', compact(
            'subdomain',
            'students',
            'classes',
            'allClasses',
            'totalClasses',
            'totalStudents',
            'maleStudents',
            'femaleStudents',
            'malePercentage',
            'femalePercentage'
        ));
    }
}