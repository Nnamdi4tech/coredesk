<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Subject;
use App\Models\SchoolClass;
use Illuminate\Support\Facades\DB;

class SubjectController extends Controller
{
    public function index($subdomain)
    {
        $tenantId = auth()->user()->tenant_id;
        
        // Get all subjects
        $subjects = Subject::where('tenant_id', $tenantId)->paginate(10);
        
        
        // CARD 1: Total Subjects
        $totalSubjects = $subjects->count();
        
        // CARD 2: Subjects with Teachers Assigned
        $subjectsWithTeachers = DB::table('teacher_subjects')
                                  ->where('tenant_id', $tenantId)
                                  ->distinct('subject_id')
                                  ->count('subject_id');
        
        // CARD 3: Total Classes (from SchoolClass table)
        $totalClasses = SchoolClass::where('tenant_id', $tenantId)->count();
        
        // CARD 4: Subjects without Teachers (not assigned)
        $subjectsWithoutTeachers = $totalSubjects - $subjectsWithTeachers;
        
        // Calculate percentages
        $assignedPercentage = $totalSubjects > 0 ? round(($subjectsWithTeachers / $totalSubjects) * 100) : 0;
        $unassignedPercentage = $totalSubjects > 0 ? round(($subjectsWithoutTeachers / $totalSubjects) * 100) : 0;

        return view('admin.subjects.index', compact(
            'subdomain',
            'subjects',
            'totalSubjects',
            'subjectsWithTeachers',
            'totalClasses',
            'subjectsWithoutTeachers',
            'assignedPercentage',
            'unassignedPercentage'
        ));
    }


    public function create($subdomain)
{
    $teachers = \App\Models\Teacher::where('tenant_id', auth()->user()->tenant_id)->get();
    $classes = \App\Models\SchoolClass::where('tenant_id', auth()->user()->tenant_id)->get();
    

    return view('admin.subjects.create', compact('subdomain', 'teachers', 'classes'));
}

    

public function store(Request $request, $subdomain)
{
    $request->validate([
        'name' => 'required',
        'teacher_id' => 'required|exists:teachers,id',
        'class_id' => 'required|exists:school_classes,id',
    ]);

    // ✅ Create Subject
    $subject = Subject::create([
        'tenant_id' => auth()->user()->tenant_id,
        'name' => $request->name,
        'course_code' => $request->course_code,
        'description' => $request->description,
    ]);

    // ✅ Assign Teacher + Class
    if ($request->teacher_id) {
        DB::table('teacher_subjects')->insert([
            'tenant_id' => auth()->user()->tenant_id,
            'teacher_id' => $request->teacher_id,
            'subject_id' => $subject->id,
            'class_id' => $request->class_id,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    return redirect()->route('tenant.subjects.index', $subdomain)
        ->with('success', 'Subject assigned to teacher and class successfully');
}

public function edit($subdomain, $id)
    {
        $subject = Subject::where('tenant_id', auth()->user()->tenant_id)
                          ->where('id', $id)
                          ->firstOrFail();

        $teachers = \App\Models\Teacher::where('tenant_id', auth()->user()->tenant_id)->get();
        $classes  = \App\Models\SchoolClass::where('tenant_id', auth()->user()->tenant_id)->get();

        // Get current assignment
        $assignment = DB::table('teacher_subjects')
                        ->where('tenant_id', auth()->user()->tenant_id)
                        ->where('subject_id', $subject->id)
                        ->first();

        return view('admin.subjects.edit', compact('subdomain', 'subject', 'teachers', 'classes', 'assignment'));
    }

    public function update(Request $request, $subdomain, $id)
    {
        $subject = Subject::where('tenant_id', auth()->user()->tenant_id)
                          ->where('id', $id)
                          ->firstOrFail();

        $request->validate([
            'name'       => 'required|string|max:255',
            'teacher_id' => 'required|exists:teachers,id',
            'class_id'   => 'required|exists:school_classes,id',
        ]);

        $subject->update([
            'name'        => $request->name,
            'course_code' => $request->course_code,
            'description' => $request->description,
        ]);

        // Remove old assignment and re-insert
        DB::table('teacher_subjects')
          ->where('tenant_id', auth()->user()->tenant_id)
          ->where('subject_id', $subject->id)
          ->delete();

        if ($request->teacher_id) {
            DB::table('teacher_subjects')->insert([
                'tenant_id'  => auth()->user()->tenant_id,
                'teacher_id' => $request->teacher_id,
                'subject_id' => $subject->id,
                'class_id'   => $request->class_id,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        return redirect()->route('tenant.subjects.index', $subdomain)
                         ->with('success', 'Subject updated successfully.');
    }

    public function destroy($subdomain, $id)
    {
        $subject = Subject::where('tenant_id', auth()->user()->tenant_id)
                          ->where('id', $id)
                          ->firstOrFail();

        // Remove teacher assignments first
        DB::table('teacher_subjects')
          ->where('tenant_id', auth()->user()->tenant_id)
          ->where('subject_id', $subject->id)
          ->delete();

        $subject->delete();

        return redirect()->route('tenant.subjects.index', $subdomain)
                         ->with('success', 'Subject deleted successfully.');
    }
}