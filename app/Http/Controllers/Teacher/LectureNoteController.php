<?php
// app/Http/Controllers/Teacher/LectureNoteController.php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\LectureNote;
use App\Models\Teacher;
use App\Models\Subject;
use App\Models\SchoolClass;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class LectureNoteController extends Controller
{
    public function index($subdomain)
    {
        $teacher = Teacher::where('user_id', auth()->id())->first();
        
        if (!$teacher) {
            return redirect()->back()->with('error', 'Teacher profile not found.');
        }
        
        // Get teacher's assigned classes and subjects via pivot
        $assignments = DB::table('teacher_subjects')
            ->where('teacher_id', $teacher->id)
            ->get();
        
        $classIds = $assignments->pluck('class_id')->unique();
        $subjectIds = $assignments->pluck('subject_id')->unique();
        
        // Get all lecture notes for this teacher
        $lectureNotes = LectureNote::where('tenant_id', auth()->user()->tenant_id)
            ->where('teacher_id', $teacher->id)
            ->with(['subject', 'class'])
            ->orderBy('created_at', 'desc')
            ->get();
        
        $subjects = Subject::whereIn('id', $subjectIds)
            ->where('tenant_id', auth()->user()->tenant_id)
            ->get();
        
        $classes = SchoolClass::whereIn('id', $classIds)
            ->where('tenant_id', auth()->user()->tenant_id)
            ->get();
        
        // Stats
        $totalNotes = $lectureNotes->count();
        $approvedNotes = $lectureNotes->where('approved', true)->count();
        $pendingNotes = $lectureNotes->where('approved', false)->where('rejected', false)->count();
        $rejectedNotes = $lectureNotes->where('rejected', true)->count();
        
        return view('teacher.lecture_note.index', compact(
            'subdomain',
            'lectureNotes',
            'subjects',
            'classes',
            'totalNotes',
            'approvedNotes',
            'pendingNotes',
            'rejectedNotes'
        ));
    }
    
    public function create($subdomain)
    {
        $teacher = Teacher::where('user_id', auth()->id())->first();
        
        $assignments = DB::table('teacher_subjects')
            ->where('teacher_id', $teacher->id)
            ->get();
        
        $subjectIds = $assignments->pluck('subject_id')->unique();
        $classIds = $assignments->pluck('class_id')->unique();
        
        $subjects = Subject::whereIn('id', $subjectIds)
            ->where('tenant_id', auth()->user()->tenant_id)
            ->get();
        
        $classes = SchoolClass::whereIn('id', $classIds)
            ->where('tenant_id', auth()->user()->tenant_id)
            ->get();
        
        return view('teacher.lecture_note.create', compact('subdomain', 'subjects', 'classes'));
    }
    
    public function store(Request $request, $subdomain)
    {
        $teacher = Teacher::where('user_id', auth()->id())->first();
        
        $request->validate([
            'subject_id' => 'required|exists:subjects,id',
            'class_id' => 'required|exists:school_classes,id',
            'title' => 'required|string|max:255',
            'type' => 'required|in:text,file',
            'content' => 'required_if:type,text|nullable|string',
            'file' => 'required_if:type,file|nullable|file|mimes:pdf,doc,docx,txt|max:10240',
        ]);
        
        $lectureNote = new LectureNote();
        $lectureNote->tenant_id = auth()->user()->tenant_id;
        $lectureNote->teacher_id = $teacher->id;
        $lectureNote->subject_id = $request->subject_id;
        $lectureNote->class_id = $request->class_id;
        $lectureNote->title = $request->title;
        $lectureNote->type = $request->type;
        $lectureNote->status = 'pending';
        $lectureNote->approved = false;
        $lectureNote->rejected = false;
        
        if ($request->type === 'text') {
            $lectureNote->content = $request->content;
        } else {
            if ($request->hasFile('file')) {
                $file = $request->file('file');
                $fileName = time() . '_' . $file->getClientOriginalName();
                $filePath = $file->storeAs('lecture_notes/' . $subdomain, $fileName, 'public');
                
                $lectureNote->file_path = $filePath;
                $lectureNote->file_name = $file->getClientOriginalName();
                $lectureNote->file_type = $file->getMimeType();
                $lectureNote->content = null;
            }
        }
        
        $lectureNote->save();
        
        return redirect()->route('teacher.lecture_note.index', $subdomain)
            ->with('success', 'Lecture note submitted for approval.');
    }
    
    public function edit($subdomain, $id)
    {
        $teacher = Teacher::where('user_id', auth()->id())->first();
        
        $lectureNote = LectureNote::where('tenant_id', auth()->user()->tenant_id)
            ->where('teacher_id', $teacher->id)
            ->where('id', $id)
            ->firstOrFail();
        
        // Check if already approved - cannot edit if approved
        if ($lectureNote->approved) {
            return redirect()->route('teacher.lecture_note.index', $subdomain)
                ->with('error', 'Cannot edit an approved lecture note. Contact admin to unlock.');
        }
        
        $assignments = DB::table('teacher_subjects')
            ->where('teacher_id', $teacher->id)
            ->get();
        
        $subjectIds = $assignments->pluck('subject_id')->unique();
        $classIds = $assignments->pluck('class_id')->unique();
        
        $subjects = Subject::whereIn('id', $subjectIds)
            ->where('tenant_id', auth()->user()->tenant_id)
            ->get();
        
        $classes = SchoolClass::whereIn('id', $classIds)
            ->where('tenant_id', auth()->user()->tenant_id)
            ->get();
        
        return view('teacher.lecture_note.edit', compact('subdomain', 'lectureNote', 'subjects', 'classes'));
    }
    
    public function update(Request $request, $subdomain, $id)
    {
        $teacher = Teacher::where('user_id', auth()->id())->first();
        
        $lectureNote = LectureNote::where('tenant_id', auth()->user()->tenant_id)
            ->where('teacher_id', $teacher->id)
            ->where('id', $id)
            ->firstOrFail();
        
        if ($lectureNote->approved) {
            return redirect()->route('teacher.lecture_note.index', $subdomain)
                ->with('error', 'Cannot edit an approved lecture note.');
        }
        
        $request->validate([
            'subject_id' => 'required|exists:subjects,id',
            'class_id' => 'required|exists:school_classes,id',
            'title' => 'required|string|max:255',
            'type' => 'required|in:text,file',
            'content' => 'required_if:type,text|nullable|string',
            'file' => 'nullable|file|mimes:pdf,doc,docx,txt|max:10240',
        ]);
        
        $lectureNote->subject_id = $request->subject_id;
        $lectureNote->class_id = $request->class_id;
        $lectureNote->title = $request->title;
        $lectureNote->type = $request->type;
        
        // Reset approval status on update
        $lectureNote->status = 'pending';
        $lectureNote->approved = false;
        $lectureNote->rejected = false;
        $lectureNote->rejection_reason = null;
        
        if ($request->type === 'text') {
            $lectureNote->content = $request->content;
            // Delete old file if exists
            if ($lectureNote->file_path) {
                Storage::disk('public')->delete($lectureNote->file_path);
                $lectureNote->file_path = null;
                $lectureNote->file_name = null;
                $lectureNote->file_type = null;
            }
        } else {
            if ($request->hasFile('file')) {
                // Delete old file
                if ($lectureNote->file_path) {
                    Storage::disk('public')->delete($lectureNote->file_path);
                }
                
                $file = $request->file('file');
                $fileName = time() . '_' . $file->getClientOriginalName();
                $filePath = $file->storeAs('lecture_notes/' . $subdomain, $fileName, 'public');
                
                $lectureNote->file_path = $filePath;
                $lectureNote->file_name = $file->getClientOriginalName();
                $lectureNote->file_type = $file->getMimeType();
                $lectureNote->content = null;
            }
        }
        
        $lectureNote->save();
        
        return redirect()->route('teacher.lecture_note.index', $subdomain)
            ->with('success', 'Lecture note updated and resubmitted for approval.');
    }
    
    public function destroy($subdomain, $id)
    {
        $teacher = Teacher::where('user_id', auth()->id())->first();
        
        $lectureNote = LectureNote::where('tenant_id', auth()->user()->tenant_id)
            ->where('teacher_id', $teacher->id)
            ->where('id', $id)
            ->firstOrFail();
        
        if ($lectureNote->approved) {
            return redirect()->route('teacher.lecture_note.index', $subdomain)
                ->with('error', 'Cannot delete an approved lecture note. Contact admin to unlock.');
        }
        
        // Delete file if exists
        if ($lectureNote->file_path) {
            Storage::disk('public')->delete($lectureNote->file_path);
        }
        
        $lectureNote->delete();
        
        return redirect()->route('teacher.lecture_note.index', $subdomain)
            ->with('success', 'Lecture note deleted successfully.');
    }
    
    public function view($subdomain, $id)
    {
        $teacher = Teacher::where('user_id', auth()->id())->first();
        
        $lectureNote = LectureNote::where('tenant_id', auth()->user()->tenant_id)
            ->where('teacher_id', $teacher->id)
            ->where('id', $id)
            ->firstOrFail();
        
        return view('teacher.lecture_note.view', compact('subdomain', 'lectureNote'));
    }
}