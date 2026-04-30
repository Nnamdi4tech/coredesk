<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Timetable;
use App\Models\SchoolClass;
use App\Models\Subject;
use Illuminate\Http\Request;

class TimetableController extends Controller
{
    public function index($subdomain)
    {
        $timetables = Timetable::where('tenant_id', auth()->user()->tenant_id)
            ->with(['class', 'subject'])  // Keep original, no 'teacher' for now
            ->latest()
            ->get();

        return view('admin.timetable.index', compact('timetables', 'subdomain'));
    }

    public function create($subdomain)
    {
        $classes = SchoolClass::where('tenant_id', auth()->user()->tenant_id)->get();
        $subjects = Subject::where('tenant_id', auth()->user()->tenant_id)->get();
        $teachers = \App\Models\Teacher::where('tenant_id', auth()->user()->tenant_id)->get();

        return view('admin.timetable.create', compact('classes', 'subjects', 'teachers', 'subdomain'));
    }

    public function store(Request $request, $subdomain)
    {
        $request->validate([
            'class_id' => 'required',
            'subject_id' => 'required',
            'teacher_id' => 'required',
            'day' => 'required',
            'start_time' => 'required',
            'end_time' => 'required',
            'term' => 'required',    
            'session' => 'required',
        ]);

        Timetable::create([
            'tenant_id' => auth()->user()->tenant_id,
            'class_id' => $request->class_id,
            'subject_id' => $request->subject_id,
            'teacher_id' => $request->teacher_id,
            'day' => $request->day,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'term' => $request->term,
            'session' => $request->session,
        ]);

        return redirect()->route('tenant.timetable.index', $subdomain)
            ->with('success', 'Class Timetable added');
    }

    public function edit($subdomain, $id)
    {
        // IMPORTANT: Add tenant security check
        $timetable = Timetable::where('tenant_id', auth()->user()->tenant_id)
            ->findOrFail($id);
        
        $classes = SchoolClass::where('tenant_id', auth()->user()->tenant_id)->get();
        $subjects = Subject::where('tenant_id', auth()->user()->tenant_id)->get();
        $teachers = \App\Models\Teacher::where('tenant_id', auth()->user()->tenant_id)->get();

        return view('admin.timetable.edit', compact('timetable', 'classes', 'subjects', 'teachers', 'subdomain'));
    }

    public function update(Request $request, $subdomain, $id)
    {
        $request->validate([
            'class_id' => 'required',
            'subject_id' => 'required',
            'teacher_id' => 'required',
            'day' => 'required',
            'start_time' => 'required',
            'end_time' => 'required',
            'term' => 'required',
            'session' => 'required', 
        ]);

        // IMPORTANT: Add tenant security check
        $timetable = Timetable::where('tenant_id', auth()->user()->tenant_id)
            ->findOrFail($id);
        
        $timetable->update([
            'class_id' => $request->class_id,
            'subject_id' => $request->subject_id,
            'teacher_id' => $request->teacher_id,
            'day' => $request->day,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'term' => $request->term,
            'session' => $request->session,
        ]);

        return redirect()->route('tenant.timetable.index', $subdomain)
            ->with('success', 'Updated successfully');
    }

    public function destroy($subdomain, $id)
    {
        // IMPORTANT: Add tenant security check
        $timetable = Timetable::where('tenant_id', auth()->user()->tenant_id)
            ->findOrFail($id);
        
        $timetable->delete();

        // Keep original 'back()' behavior
        return back()->with('success', 'Deleted successfully');
    }
}