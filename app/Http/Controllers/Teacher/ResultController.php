<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Result;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\Subject;

class ResultController extends Controller
{
    public function index($subdomain)
{
    $teacher = Teacher::where('user_id', auth()->id())->first();

    $results = Result::where('teacher_id', $teacher->id)
        ->with(['student', 'subject'])
        ->get();

    return view('teacher.results.index', compact('results', 'subdomain'));
}


public function create($subdomain)
{
    $teacher = Teacher::where('user_id', auth()->id())->first();

    // ✅ Get teacher assignments (subject + class)
    $assignments = \DB::table('teacher_subjects')
        ->where('teacher_id', $teacher->id)
        ->get();

    // ✅ Extract class IDs
    $classIds = $assignments->pluck('class_id')->unique();

    // ✅ Get students in those classes
    $students = Student::whereIn('class_id', $classIds)->get();

    // ✅ Get subjects assigned to teacher (via pivot)
    $subjectIds = $assignments->pluck('subject_id')->unique();

    $subjects = Subject::whereIn('id', $subjectIds)
        ->where('tenant_id', auth()->user()->tenant_id)
        ->get();

    // ✅ TERM (STATIC)
    $terms = ['First Term', 'Second Term', 'Third Term'];

    // ✅ SESSION (DYNAMIC)
$currentYear = date('Y');
$sessions = [];

// Add current academic year (e.g., 2026/2027)
$sessions[] = $currentYear . '/' . ($currentYear + 1);

// Add previous 5 sessions
for ($i = 0; $i < 5; $i++) {
    $start = $currentYear - $i - 1;
    $end = $currentYear - $i;
    $sessions[] = $start . '/' . $end;
}

// Remove duplicates and keep unique values
$sessions = array_unique($sessions);
$sessions = array_values($sessions);

    return view('teacher.results.create', compact(
        'students',
        'subjects',
        'terms',
        'sessions',
        'subdomain'
    ));
}

    public function edit($subdomain, $studentId)
{
    $student = Student::findOrFail($studentId);

    // ✅ Fetch the ONE specific result using all three filters from the URL
    $result = Result::where('student_id', $studentId)
        ->where('tenant_id', auth()->user()->tenant_id)
        ->where('subject_id', request('subject_id'))
        ->where('term', request('term'))
        ->where('session', request('session'))
        ->first();

    // ✅ Get the subject directly — no need for full subject list
    $subject = Subject::find(request('subject_id'));

    return view('teacher.results.edit', compact('student', 'subject', 'result', 'subdomain'));
}

    public function update(Request $request, $subdomain, $studentId)
{
    $teacher = Teacher::where('user_id', auth()->id())->first();
    $student = Student::findOrFail($studentId);

    $result = Result::where('student_id', $studentId)
        ->where('subject_id', $request->subject_id)
        ->first();

    // ✅ CHANGE THIS CONDITION
    // OLD: if ($result && $result->submitted) {
    // NEW:
    if ($result && $result->submitted && !$result->rejected) {
        return back()->with('error', 'Result already approved/submitted. Cannot edit.');
    }

    $total = $request->ca1 + $request->ca2  + $request->exam;
    $average = $total / 3;

    if ($total >= 70) {
        $grade = 'A'; $remark = 'Excellent';
    } elseif ($total >= 60) {
        $grade = 'B'; $remark = 'Very Good';
    } elseif ($total >= 50) {
        $grade = 'C'; $remark = 'Good';
    } elseif ($total >= 45) {
        $grade = 'D'; $remark = 'Fair';
    } elseif ($total >= 40) {
        $grade = 'E'; $remark = 'Pass';
    } else {
        $grade = 'F'; $remark = 'Fail';
    }

    Result::updateOrCreate(
        [
            'tenant_id'  => auth()->user()->tenant_id,
            'student_id' => $studentId,
            'subject_id' => $request->subject_id,
            'class_id'   => $student->class_id,
            'term'       => $request->term,
            'session'    => $request->session,
        ],
        [
            'tenant_id'  => auth()->user()->tenant_id,
            'teacher_id' => $teacher->id,
            'class_id'   => $student->class_id,
            'term'       => $request->term,
            'session'    => $request->session,
            'ca1'        => $request->ca1,
            'ca2'        => $request->ca2,
            'ca3'        => null,
            'exam'       => $request->exam,
            'total'      => $total,
            'average'    => $average,
            'grade'      => $grade,
            'remark'     => $remark,
            // ✅ ADD THESE THREE LINES TO RESET FLAGS ON RESUBMISSION
            'submitted'  => true,
            'approved'   => false,
            'rejected'   => false,
        ]
    );

    // ✅ FIXED — was missing $student->class_id
    $this->calculatePositions($request->subject_id, $student->class_id, $request->term, $request->session);

    return back()->with('success', 'Result updated and resubmitted for approval');
}

 
    public function submit($subdomain, $subjectId)
{
    $teacher = Teacher::where('user_id', auth()->id())->first();
    

    Result::where('tenant_id', auth()->user()->tenant_id)
        ->where('teacher_id', $teacher->id) 
        ->where('subject_id', $subjectId)
        ->where('term', request('term'))       // ✅ ADDED
        ->where('session', request('session')) // ✅ ADDED
        ->update(['submitted' => true]);

    return back()->with('success', 'Results submitted successfully. Editing locked.');
}

// bulk entry
public function bulk(Request $request, $subdomain)
{
    $teacher = Teacher::where('user_id', auth()->id())->first();

    $assignments = \DB::table('teacher_subjects')
        ->where('teacher_id', $teacher->id)
        ->get();

    $classIds = $assignments->pluck('class_id')->unique();
    $students = Student::whereIn('class_id', $classIds)->get();

    $subjectIds = $assignments->pluck('subject_id')->unique();
    $subjects   = Subject::whereIn('id', $subjectIds)
        ->where('tenant_id', auth()->user()->tenant_id)
        ->get();

    $selectedSubject = $request->subject_id;
    $results         = [];

    if ($selectedSubject) {
        $results = Result::where('subject_id', $selectedSubject)
            ->where('teacher_id', $teacher->id)
            ->get()
            ->keyBy('student_id');
    }

    // ✅ AJAX — return the full view with markers for extraction
    if ($request->ajax() || $request->has('_ajax')) {
        // Render the full view
        $fullHtml = view('teacher.results.bulk', compact(
            'students', 'subjects', 'results', 'selectedSubject', 'subdomain'
        ))->render();
        
        // Extract only the bulk-content inner HTML
        $start = strpos($fullHtml, '<!-- [BULK-CONTENT-START] -->');
        $end   = strpos($fullHtml, '<!-- [BULK-CONTENT-END] -->');
        
        if ($start !== false && $end !== false) {
            $innerHtml = substr($fullHtml, $start + strlen('<!-- [BULK-CONTENT-START] -->'), $end - $start - strlen('<!-- [BULK-CONTENT-START] -->'));
            return response($innerHtml)->header('Content-Type', 'text/html');
        }
        
        // Fallback: return the whole thing
        return response($fullHtml)->header('Content-Type', 'text/html');
    }

    // ✅ Normal full-page request
    return view('teacher.results.bulk', compact(
        'students', 'subjects', 'results', 'selectedSubject', 'subdomain'
    ));
}

// bulk storage
public function bulkStore(Request $request, $subdomain)
{
    $teacher = Teacher::where('user_id', auth()->id())->first();

    // ✅ Backend validation per student
    foreach ($request->results as $studentId => $data) {
        if (($data['ca1'] ?? 0) > 20) {
            return back()->with('error', 'CA1 cannot exceed 20.');
        }
        if (($data['ca2'] ?? 0) > 20) {
            return back()->with('error', 'CA2 cannot exceed 20.');
        }
        if (($data['exam'] ?? 0) > 60) {
            return back()->with('error', 'Exam score cannot exceed 60.');
        }
    }

    $classId = null;
    $savedCount = 0;

    foreach ($request->results as $studentId => $data) {

        $student = Student::findOrFail($studentId);
        $classId = $student->class_id;

        $ca1   = $data['ca1'] ?? 0;
        $ca2   = $data['ca2'] ?? 0;
        $ca3   = null;
        $exam  = $data['exam'] ?? 0;
        $total = $ca1 + $ca2 + $exam;
        $average = $total / 3;

        if ($total >= 70) {
            $grade = 'A'; $remark = 'Excellent';
        } elseif ($total >= 60) {
            $grade = 'B'; $remark = 'Very Good';
        } elseif ($total >= 50) {
            $grade = 'C'; $remark = 'Good';
        } elseif ($total >= 45) {
            $grade = 'D'; $remark = 'Fair';
        } elseif ($total >= 40) {
            $grade = 'E'; $remark = 'Pass';
        } else {
            $grade = 'F'; $remark = 'Fail';
        }

        $existing = Result::where('tenant_id', auth()->user()->tenant_id)
            ->where('student_id', $studentId)
            ->where('subject_id', $request->subject_id)
            ->where('term', $request->term)
            ->where('session', $request->session)
            ->first();

        // ✅ Allow editing if it was rejected (resubmission)
        if ($existing && $existing->submitted && !$existing->rejected) {
            continue; // Skip if already approved/submitted
        }

        Result::updateOrCreate(
            [
                'tenant_id'  => auth()->user()->tenant_id,
                'student_id' => $studentId,
                'subject_id' => $request->subject_id,
                'class_id'   => $student->class_id,
                'term'       => $request->term,
                'session'    => $request->session,
            ],
            [
                'teacher_id' => $teacher->id,
                'class_id'   => $student->class_id,
                'term'       => $request->term,
                'session'    => $request->session,
                'ca1'        => $ca1,
                'ca2'        => $ca2,
                'ca3'        => null,
                'exam'       => $exam,
                'total'      => $total,
                'average'    => $average,
                'grade'      => $grade,
                'remark'     => $remark,
                // ✅ Reset flags on resubmission
                'submitted'  => true,
                'approved'   => false,
                'rejected'   => false,
            ]
        );
        $savedCount++;
    }

    if ($classId) {
        $this->calculatePositions($request->subject_id, $classId, $request->term, $request->session);
    }

    // ✅ If Save & Submit was clicked — now submit after saving
    if ($request->should_submit == '1') {
        Result::where('tenant_id', auth()->user()->tenant_id)
            ->where('teacher_id', $teacher->id)
            ->where('subject_id', $request->subject_id)
            ->where('term', $request->term)
            ->where('session', $request->session)
            ->update(['submitted' => true]);

        return redirect()->route('tenant.teacher.results.index', $subdomain)
            ->with('success', 'Results saved and submitted successfully. Editing locked.');
    }

    return redirect()->route('tenant.teacher.results.index', $subdomain)
        ->with('success', "{$savedCount} result(s) saved successfully");
}

public function store(Request $request, $subdomain)
    {
        $teacher = Teacher::where('user_id', auth()->id())->first();
        $student = Student::findOrFail($request->student_id);

        // 🧠 CALCULATIONS
        $total = $request->ca1 + $request->ca2  + $request->exam;
        $average = $total / 3;

        // 🎓 GRADE LOGIC
        if ($total >= 70) {
            $grade = 'A'; $remark = 'Excellent';
        } elseif ($total >= 60) {
            $grade = 'B'; $remark = 'Very Good';
        } elseif ($total >= 50) {
            $grade = 'C'; $remark = 'Good';
        } elseif ($total >= 45) {
            $grade = 'D'; $remark = 'Fair';
        } elseif ($total >= 40) {
            $grade = 'E'; $remark = 'Pass';
        } else {
            $grade = 'F'; $remark = 'Fail';
        }

        $result = Result::create([
            'tenant_id' => auth()->user()->tenant_id,
            'teacher_id' => $teacher->id,
            'student_id' => $request->student_id,
            'subject_id' => $request->subject_id,
            'class_id' => $student->class_id,
            // ✅ ADD THESE
    'term' => $request->term,
    'session' => $request->session,
            'ca1' => $request->ca1,
            'ca2' => $request->ca2,
            'ca3' => null,
            'exam' => $request->exam,
            'total' => $total,
            'average' => $average,
            'grade' => $grade,
            'remark' => $remark,
        ]);

        // 🔥 POSITION CALCULATION
        $this->calculatePositions($request->subject_id, $student->class_id, $request->term, $request->session);

        return redirect()->route('tenant.teacher.results.index', $subdomain)
            ->with('success', 'Result added successfully');
    }

    // 🏆 POSITION LOGIC
    private function calculatePositions($subject_id, $class_id, $term, $session)
{
    $results = Result::where('tenant_id', auth()->user()->tenant_id)
        ->where('subject_id', $subject_id)
        ->where('class_id', $class_id)
        ->where('term', $term)       // ✅ FIXED — use param not request()
        ->where('session', $session) // ✅ FIXED — use param not request()
        ->orderByDesc('total')
        ->get();

    $position = 1;

    foreach ($results as $result) {
        $result->update(['position' => $position]);
        $position++;
    }
}

    





}