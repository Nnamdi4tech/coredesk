<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Teacher;
use App\Models\Student;
use App\Models\SchoolClass;
use App\Models\Subject;
use App\Models\Attendance;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AttendanceController extends Controller
{
    public function index($subdomain, Request $request)
    {
        $teacherId = Auth::user()->teacher->id ?? null;
        $tenantId = Auth::user()->tenant_id;
        
        if (!$teacherId) {
            return view('teacher.attendance.index', compact('subdomain'))->with('error', 'Teacher profile not found.');
        }
        
        // Get all classes for filter dropdown
        $classes = SchoolClass::where('tenant_id', $tenantId)->get();
        
        // Get subjects taught by this teacher
        $subjects = Subject::whereHas('teachers', function($query) use ($teacherId) {
            $query->where('teacher_id', $teacherId);
        })->get();
        
        // Get filter values from request
        $selectedClass = $request->get('class_id');
        $selectedSubject = $request->get('subject_id');
        $selectedTerm = $request->get('term', 'First Term');
        $selectedSession = $request->get('session', date('Y') . '/' . (date('Y') + 1));
        
        // Get students filtered by class
        $studentsQuery = Student::where('tenant_id', $tenantId)
                                ->where('teacher_id', $teacherId);
        
        if ($selectedClass) {
            $studentsQuery->where('class_id', $selectedClass);
        }
        
        $students = $studentsQuery->with('schoolClass')->get();
        
        // Get existing attendance records based on filters
        $existingAttendance = Attendance::where('tenant_id', $tenantId)
                                ->where('teacher_id', $teacherId)
                                ->when($selectedSubject, function($query) use ($selectedSubject) {
                                    return $query->where('subject_id', $selectedSubject);
                                })
                                ->where('term', $selectedTerm)
                                ->where('session', $selectedSession)
                                ->get();  // Just get collection, no grouping
        
        // Get all available sessions for dropdown (from existing attendance or generate)
        $availableSessions = Attendance::where('tenant_id', $tenantId)
                                       ->where('teacher_id', $teacherId)
                                       ->distinct()
                                       ->pluck('session')
                                       ->toArray();
        
        if (empty($availableSessions)) {
            $availableSessions = [date('Y') . '/' . (date('Y') + 1)];
        }
        
        // Get all available terms
        $availableTerms = ['First Term', 'Second Term', 'Third Term'];
        
        return view('teacher.attendance.index', compact(
            'subdomain',
            'students',
            'subjects',
            'classes',
            'existingAttendance',
            'selectedClass',
            'selectedSubject',
            'selectedTerm',
            'selectedSession',
            'availableSessions',
            'availableTerms'
        ));
    }
    
    public function store(Request $request, $subdomain)
    {
        $teacherId = Auth::user()->teacher->id ?? null;
        $tenantId = Auth::user()->tenant_id;
        
        $request->validate([
            'attendance' => 'required|array',
            'term' => 'required|string',
            'session' => 'required|string',
        ]);
        
        DB::beginTransaction();
        
        try {
            $savedCount = 0;
            $skippedCount = 0;
            
            foreach ($request->attendance as $data) {
                // Check if attendance already exists
                $exists = Attendance::where('tenant_id', $tenantId)
                                    ->where('student_id', $data['student_id'])
                                    ->where('subject_id', $data['subject_id'])
                                    ->where('term', $request->term)
                                    ->where('session', $request->session)
                                    ->exists();
                
                if ($exists) {
                    $skippedCount++;
                    continue;
                }
                
                $score = $data['score'] ?? null;
                $rating = $score ? Attendance::getRating($score) : null;
                
                Attendance::create([
                    'tenant_id' => $tenantId,
                    'student_id' => $data['student_id'],
                    'teacher_id' => $teacherId,
                    'class_id' => $data['class_id'],
                    'subject_id' => $data['subject_id'],
                    'term' => $request->term,
                    'session' => $request->session,
                    'score' => $score,
                    'rating' => $rating,
                    'remarks' => $data['remarks'] ?? null,
                ]);
                $savedCount++;
            }
            
            DB::commit();
            
            $message = "Attendance recorded successfully!";
            if ($savedCount > 0) {
                $message = "$savedCount record(s) saved successfully.";
            }
            if ($skippedCount > 0) {
                $message .= " $skippedCount record(s) skipped (already exist).";
            }
            
            return redirect()->route('teacher.attendance.index', array_merge([$subdomain], $request->only(['class_id', 'subject_id', 'term', 'session'])))
                ->with('success', $message);
                
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Failed to record attendance. Please try again.');
        }
    }
    
    public function viewRecord($subdomain, Request $request)
    {
        $teacherId = Auth::user()->teacher->id ?? null;
        $tenantId = Auth::user()->tenant_id;
        
        // Get filter values
        $selectedSubject = $request->get('subject_id');
        $selectedClass = $request->get('class_id');
        $selectedTerm = $request->get('term');
        $selectedSession = $request->get('session');
        
        $attendances = Attendance::where('tenant_id', $tenantId)
                                ->where('teacher_id', $teacherId)
                                ->when($selectedSubject, function($query) use ($selectedSubject) {
                                    return $query->where('subject_id', $selectedSubject);
                                })
                                ->when($selectedClass, function($query) use ($selectedClass) {
                                    return $query->where('class_id', $selectedClass);
                                })
                                ->when($selectedTerm, function($query) use ($selectedTerm) {
                                    return $query->where('term', $selectedTerm);
                                })
                                ->when($selectedSession, function($query) use ($selectedSession) {
                                    return $query->where('session', $selectedSession);
                                })
                                ->with(['student', 'subject', 'class'])
                                ->orderBy('created_at', 'desc')
                                ->paginate(20);
        
        // Get filter options
        $subjects = Subject::whereHas('teachers', function($query) use ($teacherId) {
            $query->where('teacher_id', $teacherId);
        })->get();
        
        $classes = SchoolClass::where('tenant_id', $tenantId)->get();
        $sessions = Attendance::where('tenant_id', $tenantId)->distinct()->pluck('session');
        $terms = ['First Term', 'Second Term', 'Third Term'];
        
        return view('teacher.attendance.view', compact(
            'subdomain',
            'attendances',
            'subjects',
            'classes',
            'sessions',
            'terms',
            'selectedSubject',
            'selectedClass',
            'selectedTerm',
            'selectedSession'
        ));
    }
}