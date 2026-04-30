<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Result;
use App\Models\Subject;
use App\Models\Teacher;
use App\Models\Student;

class AdminResultController extends Controller
{
    // 📊 LIST ALL SUBMITTED RESULTS
    public function index($subdomain)
    {
        $results = Result::where('tenant_id', auth()->user()->tenant_id)
    ->where('submitted', true)
    ->select('subject_id', 'teacher_id', 'class_id')
    ->distinct()
    ->with(['subject', 'teacher'])
    ->get();

        return view('admin.results.index', compact('results', 'subdomain'));
    }

    // 👁 VIEW RESULT SHEET
    
    public function show($subdomain, $subjectId, $classId)
{
    $results = Result::where('tenant_id', auth()->user()->tenant_id)
    ->where('submitted', true)
    ->select('subject_id', 'teacher_id', 'class_id')
    ->groupBy('subject_id', 'teacher_id', 'class_id') // ✅ FIX
    ->with(['subject', 'teacher'])
    ->get();

    $subject = Subject::findOrFail($subjectId);

    return view('admin.results.show', compact('results', 'subdomain', 'subject', 'classId'));
}

    // ✅ APPROVE
    public function approve($subdomain, $subjectId, $classId)
{
    Result::where('tenant_id', auth()->user()->tenant_id)
        ->where('subject_id', $subjectId)
        ->where('class_id', $classId)
        ->update([
            'approved' => true,
            'rejected' => false
        ]);

    return redirect()
        ->route('tenant.admin.results.index', $subdomain)
        ->with('success', 'Results approved successfully');
}

    // ❌ REJECT (IMPORTANT)
    public function reject($subdomain, $subjectId, $classId)
 {
    Result::where('tenant_id', auth()->user()->tenant_id)
        ->where('subject_id', $subjectId)
        ->where('class_id', $classId)
        ->update([
            'approved' => false,
            'rejected' => true,
            'submitted' => false
        ]);

    return redirect()
        ->route('tenant.admin.results.index', $subdomain)
        ->with('success', 'Results rejected and unlocked for teacher');
 }

    // ✅ APPROVE SINGLE STUDENT
public function approveOne($subdomain, $resultId)
{
    Result::where('id', $resultId)
    ->where('tenant_id', auth()->user()->tenant_id)
    ->update([
        'approved' => true,
        'rejected' => false
    ]);

    return back()->with('success', 'Student result approved');
}


// ❌ REJECT SINGLE STUDENT (UNLOCK)
public function rejectOne($subdomain, $resultId)
{
    Result::where('id', $resultId)
    ->where('tenant_id', auth()->user()->tenant_id)
    ->update([
        'approved' => false,
        'rejected' => true,
        'submitted' => false
    ]);

    return back()->with('success', 'Student result rejected and unlocked');
}


public function classResults($subdomain, $classId)
{
    $tenantId = auth()->user()->tenant_id;

    $students = Student::where('tenant_id', $tenantId)
        ->where('class_id', $classId)
        ->get();

    return view('admin.results.class_students', compact('students', 'classId', 'subdomain'));
}

public function studentReport($subdomain, $studentId)
{
    $tenantId = auth()->user()->tenant_id;

    $student = Student::where('tenant_id', $tenantId)
        ->findOrFail($studentId);

    $results = Result::with('subject')
        ->where('tenant_id', $tenantId)
        ->where('student_id', $studentId)
        ->where('class_id', $student->class_id)
        ->get();

    // totals
    foreach ($results as $result) {
        $result->total = $result->ca1 + $result->ca2 + $result->ca3 + $result->exam;
    }

    $overallTotal = $results->sum('total');
    $overallAverage = $results->count() ? $overallTotal / $results->count() : 0;

    // positions
    $classResults = Result::where('tenant_id', $tenantId)
        ->where('class_id', $student->class_id)
        ->get()
        ->groupBy('student_id');

    $positions = [];

    foreach ($classResults as $stuId => $res) {
        $positions[$stuId] = $res->sum(fn($r) => 
            $r->ca1 + $r->ca2 + $r->ca3 + $r->exam
        );
    }

    arsort($positions);

    $rank = array_keys($positions);
    $overallPosition = array_search($studentId, $rank) + 1;

    return view('admin.results.student_report', compact(
        'student',
        'results',
        'overallTotal',
        'overallAverage',
        'overallPosition',
        'subdomain'
    ));
}








}