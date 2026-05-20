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
    // 📊 LIST ALL SUBMITTED RESULTS GROUPED BY SUBJECT, CLASS, AND TEACHER
    public function index($subdomain)
{
    $tenantId = auth()->user()->tenant_id;
    
    // Get all submitted results
    $allResults = Result::where('tenant_id', $tenantId)
        ->where('submitted', true)
        ->with(['subject', 'teacher'])
        ->get();
    
    // Calculate counts
    $pendingOnly = $allResults->where('approved', false)->where('rejected', false)->count();
    $needsRevision = $allResults->where('rejected', true)->count();
    $approvedCount = $allResults->where('approved', true)->count();
    
    // Total needing attention (Pending + Needs Revision)
    $totalNeedsAttention = $pendingOnly + $needsRevision;
    
    // Subjects with any results needing attention
    $subjectsNeedingAttention = $allResults
        ->where('approved', false)  // Includes pending + rejected
        ->pluck('subject_id')
        ->unique()
        ->count();
    
    // Group by subject, class, teacher for display
    $query = Result::where('tenant_id', $tenantId)
    ->where('submitted', true)
    ->select('subject_id', 'teacher_id', 'class_id', 'created_at')
    ->distinct()
    ->with(['subject', 'teacher']);

if (request('teacher')) {
    $query->whereHas('teacher', fn($q) =>
        $q->where('name', 'like', '%' . request('teacher') . '%')
    );
}

if (request('subject')) {
    $query->whereHas('subject', fn($q) =>
        $q->where('name', 'like', '%' . request('subject') . '%')
    );
}

if (request('date')) {
    $query->whereDate('created_at', request('date'));
}

$results = $query->orderByDesc('created_at')
    ->paginate(3)
    ->appends(request()->query());
    
    // Attach status summary to each grouped result
    foreach ($results as $result) {
        $subjectResults = Result::where('tenant_id', $tenantId)
            ->where('subject_id', $result->subject_id)
            ->where('class_id', $result->class_id)
            ->where('submitted', true)
            ->get();
        
        $result->pending_in_group = $subjectResults->where('approved', false)->where('rejected', false)->count();
        $result->approved_in_group = $subjectResults->where('approved', true)->count();
        $result->rejected_in_group = $subjectResults->where('rejected', true)->count();
        $result->total_students = $subjectResults->count();
    }

    return view('admin.results.index', compact(
        'results', 
        'subdomain', 
        'totalNeedsAttention',
        'subjectsNeedingAttention',
        'approvedCount',
        'pendingOnly',
        'needsRevision'
    ));
}

    // 👁 VIEW RESULT SHEET FOR SPECIFIC SUBJECT AND CLASS
    public function show($subdomain, $subjectId, $classId)
    {
        $results = Result::where('tenant_id', auth()->user()->tenant_id)
            ->where('subject_id', $subjectId)
            ->where('class_id', $classId)
            ->where('submitted', true)
            ->with(['student', 'subject', 'teacher'])
            ->get();

        $subject = Subject::findOrFail($subjectId);
        
        // Calculate totals
        foreach ($results as $result) {
            $result->total = $result->ca1 + $result->ca2 + $result->exam;
        }

        return view('admin.results.show', compact('results', 'subdomain', 'subject', 'classId'));
    }

    // ✅ APPROVE ALL RESULTS FOR A SPECIFIC SUBJECT AND CLASS
public function approve($subdomain, $subjectId, $classId)
{
    // Count pending records
    $pendingCount = Result::where('tenant_id', auth()->user()->tenant_id)
        ->where('subject_id', $subjectId)
        ->where('class_id', $classId)
        ->where('submitted', true)
        ->where('approved', false)
        ->count();
    
    if ($pendingCount === 0) {
        // Check if all are already approved
        $allApproved = Result::where('tenant_id', auth()->user()->tenant_id)
            ->where('subject_id', $subjectId)
            ->where('class_id', $classId)
            ->where('approved', true)
            ->count() > 0;
        
        if ($allApproved) {
            return redirect()
                ->route('tenant.admin.results.index', $subdomain)
                ->with('info', 'All results for this subject are already approved.');
        }
        
        return redirect()
            ->route('tenant.admin.results.index', $subdomain)
            ->with('warning', 'No pending results found to approve for this subject.');
    }
    
    $updated = Result::where('tenant_id', auth()->user()->tenant_id)
        ->where('subject_id', $subjectId)
        ->where('class_id', $classId)
        ->where('submitted', true)
        ->where('approved', false)
        ->update([
            'approved' => true,
            'rejected' => false,
            'submitted' => true
        ]);

    return redirect()
        ->route('tenant.admin.results.index', $subdomain)
        ->with('success', "{$updated} result(s) approved successfully.");
}

// ❌ REJECT ALL RESULTS FOR A SPECIFIC SUBJECT AND CLASS
public function reject($subdomain, $subjectId, $classId)
{
    $updated = Result::where('tenant_id', auth()->user()->tenant_id)
        ->where('subject_id', $subjectId)
        ->where('class_id', $classId)
        ->where('submitted', true)
        ->where('approved', false) // ✅ Only reject unapproved ones
        ->where('rejected', false) // ✅ Don't reject already rejected
        ->update([
            'approved' => false,
            'rejected' => true,
            'submitted' => false // Unlock for teacher to edit
        ]);

    if ($updated === 0) {
        return redirect()
            ->route('tenant.admin.results.index', $subdomain)
            ->with('error', 'No results found to reject — they may already be approved');
    }

    return redirect()
        ->route('tenant.admin.results.index', $subdomain)
        ->with('success', "Results rejected and unlocked for teacher for {$updated} student(s)");
}

    // ✅ APPROVE SINGLE STUDENT RESULT
public function approveOne($subdomain, $resultId)
{
    try {
        $result = Result::where('id', $resultId)
            ->where('tenant_id', auth()->user()->tenant_id)
            ->first();

        if (!$result) {
            return back()->with('error', 'Result not found.');
        }

        // Check if already approved
        if ($result->approved) {
            return back()->with('error', 'This result is already approved.');
        }

        // Update the result
        $result->update([
            'approved' => true,
            'rejected' => false,
            'submitted' => true
        ]);

        // Get the subject and class to redirect back to the same view
        $subjectId = $result->subject_id;
        $classId = $result->class_id;

        return redirect()
            ->route('tenant.admin.results.show', [$subdomain, $subjectId, $classId])
            ->with('success', 'Student result approved successfully. Page will refresh.');

    } catch (\Exception $e) {
        \Log::error('Approve one error: ' . $e->getMessage());
        return back()->with('error', 'An error occurred while approving the result.');
    }
}

    public function rejectOne($subdomain, $resultId)
{
    $result = Result::where('id', $resultId)
        ->where('tenant_id', auth()->user()->tenant_id)
        ->first();

    if (!$result) {
        return back()->with('error', 'Result not found');
    }

    // ✅ Block rejecting already approved result
    if ($result->approved) {
        return back()->with('error', 'Cannot reject an already approved result.');
    }

    $result->update([
        'approved' => false,
        'rejected' => true,
        'submitted' => false
    ]);

    return back()->with('success', 'Student result rejected and unlocked for editing');
}

    // 📊 VIEW CLASS RESULTS (if needed)
    public function classResults($subdomain, $classId)
    {
        $tenantId = auth()->user()->tenant_id;

        $students = Student::where('tenant_id', $tenantId)
            ->where('class_id', $classId)
            ->get();

        return view('admin.results.class_students', compact('students', 'classId', 'subdomain'));
    }

    // 📄 GENERATE STUDENT REPORT CARD
    public function studentReport(Request $request, $subdomain)
{
    $tenantId = auth()->user()->tenant_id;

    $studentId = $request->student_id;
    $classId   = $request->class_id;
    $term      = $request->term;
    $session   = $request->session;

    $student = Student::where('tenant_id', $tenantId)
        ->with('schoolClass') // ✅ eager load class
        ->findOrFail($studentId);

    // ✅ FILTERED RESULTS
    $results = Result::with('subject')
        ->where('tenant_id', $tenantId)
        ->where('student_id', $studentId)
        ->where('class_id', $classId)
        ->where('term', $term)
        ->where('session', $session)
        ->where('approved', true)
        ->get();

    foreach ($results as $result) {
        $result->total = $result->ca1 + $result->ca2  + $result->exam;
    }

    $overallTotal = $results->sum('total');
    $overallAverage = $results->count() ? $overallTotal / $results->count() : 0;

    if ($overallAverage >= 70) {
    $overallRemark = 'Excellent';
} elseif ($overallAverage >= 60) {
    $overallRemark = 'Very Good';
} elseif ($overallAverage >= 50) {
    $overallRemark = 'Good';
} elseif ($overallAverage >= 40) {
    $overallRemark = 'Pass';
} else {
    $overallRemark = 'Fail';
}

    // ✅ POSITION (FILTERED BY TERM + SESSION)
    $classResults = Result::where('tenant_id', $tenantId)
        ->where('class_id', $classId)
        ->where('term', $term)
        ->where('session', $session)
        ->where('approved', true)
        ->get()
        ->groupBy('student_id');

    $positions = [];

    foreach ($classResults as $stuId => $res) {
        $positions[$stuId] = $res->sum(fn($r) =>
            $r->ca1 + $r->ca2 + $r->exam
        );
    }

    arsort($positions);

    $cumulativeData = [];

   if ($term === 'Third Term') {

    foreach ($results as $res) {

        $termsData = Result::where('tenant_id', $tenantId)
            ->where('student_id', $studentId)
            ->where('class_id', $classId)
            ->where('subject_id', $res->subject_id)
            ->where('session', $session)
            ->where('approved', true)
            ->get()
            ->keyBy('term');

        // Get each term safely
        $t1 = isset($termsData['First Term']) 
            ? $termsData['First Term']->ca1 + $termsData['First Term']->ca2 + $termsData['First Term']->exam 
            : null;

        $t2 = isset($termsData['Second Term']) 
            ? $termsData['Second Term']->ca1 + $termsData['Second Term']->ca2 + $termsData['Second Term']->exam 
            : null;

        $t3 = isset($termsData['Third Term']) 
            ? $termsData['Third Term']->ca1 + $termsData['Third Term']->ca2 + $termsData['Third Term']->exam 
            : null;

        // Calculate average
        $scores = array_filter([$t1, $t2, $t3], fn($v) => !is_null($v));
        $avg = count($scores) ? array_sum($scores) / count($scores) : 0;

        // Grade logic
        if ($avg >= 70) $grade = 'A';
        elseif ($avg >= 60) $grade = 'B';
        elseif ($avg >= 50) $grade = 'C';
        elseif ($avg >= 40) $grade = 'D';
        else $grade = 'F';

        $cumulativeData[$res->subject_id] = [
            't1' => $t1,
            't2' => $t2,
            't3' => $t3,
            'avg' => round($avg, 2),
            'grade' => $grade,
        ];
    }
   }

    $rank = array_keys($positions);
    $overallPosition = array_search($studentId, $rank) + 1;

    $cumulativeOverallTotal = 0;
$cumulativeOverallAverage = 0;

if ($term === 'Third Term' && !empty($cumulativeData)) {

    $total = 0;
    $count = 0;

    foreach ($cumulativeData as $data) {
        $total += $data['avg'];
        $count++;
    }

    $cumulativeOverallTotal = $total;
    $cumulativeOverallAverage = $count ? $total / $count : 0;
}

    return view('admin.results.student_report', compact(
        'student',
        'results',
        'overallTotal',
        'overallAverage',
        'overallPosition',
        'term',
        'session',
        'overallRemark',
        'subdomain',
        'cumulativeData',
        'cumulativeOverallTotal',
        'cumulativeOverallAverage'
    ));
}

// filter 
public function reportFilter($subdomain)
{
    $tenantId = auth()->user()->tenant_id;

    $students = Student::where('tenant_id', $tenantId)->get();
    $classes  = \App\Models\SchoolClass::where('tenant_id', $tenantId)->get();

    // ✅ Fetch directly from DB — exactly what's stored
    $terms = Result::where('tenant_id', $tenantId)
        ->whereNotNull('term')
        ->distinct()
        ->pluck('term');

    $sessions = Result::where('tenant_id', $tenantId)
        ->whereNotNull('session')
        ->distinct()
        ->pluck('session');

    return view('admin.results.filter', compact(
        'students',
        'classes',
        'terms',
        'sessions',
        'subdomain'
    ));
}


public function classResult(Request $request, $subdomain)
{
    $classId = $request->class_id;
    $class = \App\Models\SchoolClass::find($classId);
    $term = $request->term;
    $session = $request->session;
    $tenantId = auth()->user()->tenant_id;

    // ✅ Get all subjects in this class
    $subjects = \App\Models\Subject::where('tenant_id', $tenantId)->get();

    // ✅ Get all students in class
    $students = \App\Models\Student::where('tenant_id', $tenantId)
        ->where('class_id', $classId)
        ->get();

    $final = [];

    foreach ($students as $student) {

        $studentResults = [];

        $total = 0;

        foreach ($subjects as $subject) {

            $res = \App\Models\Result::where([
                'student_id' => $student->id,
                'subject_id' => $subject->id,
                'class_id' => $classId,
                'term' => $term,
                'session' => $session,
                'approved' => true,
            ])->first();

            if ($res) {
                $subjectTotal = $res->ca1 + $res->ca2 + $res->exam;
            } else {
                $subjectTotal = 0;
            }

            $studentResults[$subject->name] = $subjectTotal;
            $total += $subjectTotal;
        }

        $average = count($subjects) ? $total / count($subjects) : 0;

        $final[] = [
            'student' => $student,
            'subjects' => $studentResults,
            'total' => $total,
            'average' => $average,
        ];
    }

    // ✅ SORT BY TOTAL DESC
    usort($final, function ($a, $b) {
        return $b['total'] <=> $a['total'];
    });

    // ✅ ASSIGN POSITION
    $position = 1;
    foreach ($final as &$item) {
        $item['position'] = $position++;
    }

    return view('admin.results.class_result', [
        'final' => $final,
        'subjects' => $subjects,
        'term' => $term,
        'session' => $session,
        'class' => $class,
        'subdomain' => $subdomain
    ]);
}















}