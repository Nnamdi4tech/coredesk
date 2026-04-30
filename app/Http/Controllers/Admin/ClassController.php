<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SchoolClass;
use App\Models\Student;
use App\Models\Subject;
use Illuminate\Support\Facades\DB;

class ClassController extends Controller
{
    public function index($subdomain)
    {
        $tenantId = auth()->user()->tenant_id;
        
        // Get all classes
        $classes = SchoolClass::where('tenant_id', $tenantId)->get();
        
        // CARD 1: Total Classes
        $totalClasses = $classes->count();
        
        // CARD 2: Total Students
        $totalStudents = Student::where('tenant_id', $tenantId)->count();
        
        // CARD 3: Total Subjects
        $totalSubjects = Subject::where('tenant_id', $tenantId)->count();
        
        // CARD 4: Subjects Assigned to Classes (from teacher_subjects pivot)
        $subjectsAssignedToClasses = DB::table('teacher_subjects')
                                      ->where('tenant_id', $tenantId)
                                      ->distinct('class_id')
                                      ->count('class_id');
        
        // Calculate average students per class
        $avgStudentsPerClass = $totalClasses > 0 ? round($totalStudents / $totalClasses) : 0;
        
        return view('admin.classes.index', compact(
            'subdomain',
            'classes',
            'totalClasses',
            'totalStudents',
            'totalSubjects',
            'subjectsAssignedToClasses',
            'avgStudentsPerClass'
        ));
    }

    public function create($subdomain)
    {
        return view('admin.classes.create', compact('subdomain'));
    }

    public function store(Request $request, $subdomain)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        SchoolClass::create([
            'tenant_id' => auth()->user()->tenant_id,
            'name'      => $request->name,
        ]);

        return redirect()->route('tenant.classes.index', $subdomain)
            ->with('success', 'Class created successfully');
    }
}