<?php
// app/Http/Controllers/Admin/LectureNoteController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\LectureNote;
use App\Models\Teacher;
use App\Models\Subject;
use App\Models\SchoolClass;
use App\Models\Tenant;
use Illuminate\Support\Facades\DB;

class LectureNoteController extends Controller
{
    public function index($subdomain)
    {
        $tenantId = auth()->user()->tenant_id;
        
        $lectureNotes = LectureNote::where('tenant_id', $tenantId)
            ->with(['teacher', 'subject', 'class'])
            ->orderBy('created_at', 'desc')
            ->paginate(15);
        
        // Stats
        $totalNotes = LectureNote::where('tenant_id', $tenantId)->count();
        $pendingNotes = LectureNote::where('tenant_id', $tenantId)->where('approved', false)->where('rejected', false)->count();
        $approvedNotes = LectureNote::where('tenant_id', $tenantId)->where('approved', true)->count();
        $rejectedNotes = LectureNote::where('tenant_id', $tenantId)->where('rejected', true)->count();
        
        $teachers = Teacher::where('tenant_id', $tenantId)->get();
        $subjects = Subject::where('tenant_id', $tenantId)->get();
        $classes = SchoolClass::where('tenant_id', $tenantId)->get();
        
        return view('admin.lecture_note.index', compact(
            'subdomain',
            'lectureNotes',
            'totalNotes',
            'pendingNotes',
            'approvedNotes',
            'rejectedNotes',
            'teachers',
            'subjects',
            'classes'
        ));
    }
    
    public function show($subdomain, $id)
    {
        $tenantId = auth()->user()->tenant_id;
        
        $lectureNote = LectureNote::where('tenant_id', $tenantId)
            ->with(['teacher', 'subject', 'class', 'approvedBy'])
            ->findOrFail($id);
        
        return view('admin.lecture_note.show', compact('subdomain', 'lectureNote'));
    }
    
    public function approve($subdomain, $id)
{
    $lectureNote = LectureNote::where('tenant_id', auth()->user()->tenant_id)
        ->where('id', $id)
        ->firstOrFail();

    if ($lectureNote->approved) {
        return redirect()->back()->with('info', 'This lecture note is already approved.');
    }

    $lectureNote->update([
        'approved' => true,
        'rejected' => false,
        'status' => 'approved',
        'approved_by' => auth()->id(),
        'approved_at' => now(),
        'rejection_reason' => null,
    ]);

    return redirect()->route('tenant.admin.lecture_note.index', $subdomain)
        ->with('success', 'Lecture note approved successfully.');
}

public function reject(Request $request, $subdomain, $id)
{
    $request->validate([
        'rejection_reason' => 'required|string|max:500',
    ]);

    $lectureNote = LectureNote::where('tenant_id', auth()->user()->tenant_id)
        ->where('id', $id)
        ->firstOrFail();

    if ($lectureNote->approved) {
        return redirect()->back()->with('error', 'Cannot reject an already approved lecture note.');
    }

    $lectureNote->update([
        'approved' => false,
        'rejected' => true,
        'status' => 'rejected',
        'rejection_reason' => $request->rejection_reason,
        'approved_by' => auth()->id(),
        'approved_at' => now(),
    ]);

    return redirect()->route('tenant.admin.lecture_note.index', $subdomain)
        ->with('success', 'Lecture note rejected. Teacher has been notified.');
}

public function destroy($subdomain, $id)
{
    $lectureNote = LectureNote::where('tenant_id', auth()->user()->tenant_id)
        ->where('id', $id)
        ->firstOrFail();

    if ($lectureNote->file_path) {
        \Storage::disk('public')->delete($lectureNote->file_path);
    }

    $lectureNote->delete();

    return redirect()->route('tenant.admin.lecture_note.index', $subdomain)
        ->with('success', 'Lecture note deleted successfully.');
}

public function bulkApprove(Request $request, $subdomain)
{
    $ids = $request->ids;

    if (empty($ids)) {
        return redirect()->back()->with('error', 'No lecture notes selected.');
    }

    LectureNote::whereIn('id', $ids)
        ->where('tenant_id', auth()->user()->tenant_id)
        ->update([
            'approved' => true,
            'rejected' => false,
            'status' => 'approved',
            'approved_by' => auth()->id(),
            'approved_at' => now(),
        ]);

    return redirect()->route('tenant.admin.lecture_note.index', $subdomain)
        ->with('success', count($ids) . ' lecture notes approved successfully.');
}
}