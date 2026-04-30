<?php 
 namespace App\Http\Controllers\Student;
 use App\Http\Controllers\Controller; 
 use App\Models\Subject; 
 use App\Models\Student; 
 use App\Models\SchoolClass; 
 use App\Models\Result; 
 use Illuminate\Http\Request;

class SubjectController extends Controller
{
    public function index($subdomain, Request $request)
{
    $studentId = session('student_id');
    
    if (!$studentId) {
        return redirect()->route('student.login', $subdomain);
    }

    $student = Student::find($studentId);

    if (!$student) {
        return redirect()->route('student.login', $subdomain);
    }

    // Get filter values
    $selectedTerm = $request->get('term', 'First Term');
    $selectedSession = $request->get('session', date('Y') . '/' . (date('Y') + 1));
    $selectedClass = $request->get('class_id', $student->class_id);

    // ✅ SECURITY CHECK (MOVED UP), to block student subject histoey remove the highlight
    // if ($selectedClass != $student->class_id) {
    //     if ($request->ajax()) {
    //         return response()->json([
    //             'error' => 'You are not a member of this class.'
    //         ], 403);
    //     }

    //     return back()->with('error', 'You are not a member of this class.');
    // }
    
    // Get all classes for filter dropdown
    $allClasses = SchoolClass::where('tenant_id', $student->tenant_id)->get();
    
    // Get subjects assigned to selected class
    $subjects = Subject::where('tenant_id', $student->tenant_id)
    ->where(function ($query) use ($selectedClass, $student, $selectedTerm, $selectedSession) {

        $query->whereHas('teachers', function ($q) use ($selectedClass) {
            $q->where('teacher_subjects.class_id', $selectedClass);
        });

    })
    ->orWhere(function ($query) use ($student, $selectedClass, $selectedTerm, $selectedSession) {

        $query->where('tenant_id', $student->tenant_id)
            ->whereIn('id', function ($q) use ($student, $selectedClass, $selectedTerm, $selectedSession) {
                $q->select('subject_id')
                    ->from('results')
                    ->where('student_id', $student->id)
                    ->where('class_id', $selectedClass)
                    ->where('term', $selectedTerm)
                    ->where('session', $selectedSession);
            });

    })
    ->distinct()
    ->get();
    
    
    // For each subject, check if result exists
    // ✅ Fetch all results once (NO multiple queries)
$results = Result::where('student_id', $student->id)
    ->where('class_id', $selectedClass)
    ->where('term', $selectedTerm)
    ->where('session', $selectedSession)
    ->get()
    ->keyBy('subject_id');

// ✅ Loop through subjects (NO DB calls inside loop)
foreach ($subjects as $subject) {
    $result = $results->get($subject->id);

    $subject->has_result = $result ? true : false;
    $subject->result_grade = $result->grade ?? null;
    $subject->result_total = $result->total ?? null;
    $subject->result_remark = $result->remark ?? null;
}
    
    // Get available sessions
    $availableSessions = Result::where('student_id', $student->id)
        ->distinct()
        ->pluck('session')
        ->toArray();
    
    if (empty($availableSessions)) {
        $availableSessions = [date('Y') . '/' . (date('Y') + 1)];
    }
    
    // Available terms
    $availableTerms = ['First Term', 'Second Term', 'Third Term'];
    
    // Class names
    $studentClass = $student->schoolClass->name ?? 'N/A';
    $selectedClassName = SchoolClass::find($selectedClass)->name ?? 'N/A';

    // AJAX response
    if ($request->ajax()) {
        return view('student.subjects.index', compact(
            'subjects',
            'selectedTerm',
            'selectedSession',
            'selectedClass',
            'selectedClassName',
            'studentClass',
            'student',
            'allClasses',
            'availableSessions',
            'availableTerms'
        ))->render();
    }

    // Normal response
    return view('student.subjects.index', compact(
        'subjects',
        'student',
        'subdomain',
        'selectedTerm',
        'selectedSession',
        'selectedClass',
        'selectedClassName',
        'availableSessions',
        'availableTerms',
        'studentClass',
        'allClasses'
    ));
}
}