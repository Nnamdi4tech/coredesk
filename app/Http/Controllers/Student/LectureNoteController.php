<?php
// app/Http/Controllers/Student/LectureNoteController.php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\LectureNote;
use App\Models\Student;
use App\Models\Subject;
use Illuminate\Support\Facades\DB;

class LectureNoteController extends Controller
{
    public function index($subdomain)
    {
        $student = currentStudent();
        
        if (!$student) {
            return redirect()->back()->with('error', 'Student not found.');
        }
        
        $tenantId = $student->tenant_id;
        $classId = $student->class_id;
        
        // Get subjects for this student's class
        $subjects = Subject::where('tenant_id', $tenantId)->get();
        
        // Get approved lecture notes for this class
        $lectureNotes = LectureNote::where('tenant_id', $tenantId)
            ->where('class_id', $classId)
            ->where('approved', true)
            ->with(['teacher', 'subject'])
            ->orderBy('created_at', 'desc')
            ->get();
        
        // Group by subject
        $groupedBySubject = $lectureNotes->groupBy('subject.name');
        
        // Stats
        $totalNotes = $lectureNotes->count();
        $subjectsWithNotes = $lectureNotes->pluck('subject_id')->unique()->count();
        
        return view('student.lecture_note.index', compact(
            'subdomain',
            'lectureNotes',
            'groupedBySubject',
            'subjects',
            'totalNotes',
            'subjectsWithNotes'
        ));
    }
    
    public function show($subdomain, $id)
    {
        $student = currentStudent();
        
        if (!$student) {
            return redirect()->back()->with('error', 'Student not found.');
        }
        
        $lectureNote = LectureNote::where('tenant_id', $student->tenant_id)
            ->where('class_id', $student->class_id)
            ->where('approved', true)
            ->where('id', $id)
            ->with(['teacher', 'subject'])
            ->firstOrFail();
        
        return view('student.lecture_note.show', compact('subdomain', 'lectureNote'));
    }
    
    public function subject($subdomain, $subjectId)
    {
        $student = currentStudent();
        
        if (!$student) {
            return redirect()->back()->with('error', 'Student not found.');
        }
        
        $subject = Subject::where('tenant_id', $student->tenant_id)
            ->where('id', $subjectId)
            ->firstOrFail();
        
        $lectureNotes = LectureNote::where('tenant_id', $student->tenant_id)
            ->where('class_id', $student->class_id)
            ->where('subject_id', $subjectId)
            ->where('approved', true)
            ->with(['teacher'])
            ->orderBy('created_at', 'desc')
            ->get();
        
        return view('student.lecture_note.subject', compact('subdomain', 'lectureNotes', 'subject'));
    }
}