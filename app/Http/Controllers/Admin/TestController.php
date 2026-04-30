<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Test;
use App\Models\SchoolClass;
use App\Models\Subject;
use Illuminate\Http\Request;

class TestController extends Controller
{
    public function index($subdomain)
    {
        $tests = Test::where('tenant_id', auth()->user()->tenant_id)
            ->with(['class', 'subject'])
            ->latest()
            ->get();

        return view('admin.test.index', compact('tests', 'subdomain'));
    }

    public function create($subdomain)
    {
        $classes = SchoolClass::where('tenant_id', auth()->user()->tenant_id)->get();
        $subjects = Subject::where('tenant_id', auth()->user()->tenant_id)->get();
        $teachers = \App\Models\Teacher::where('tenant_id', auth()->user()->tenant_id)->get();

        return view('admin.test.create', compact('classes', 'subjects', 'teachers', 'subdomain'));
    }

    public function store(Request $request, $subdomain)
    {
        // ===== DEBUG START =====
        // dd([
        //     'ALL INPUT'         => $request->all(),
        //     'class_id'          => $request->class_id,
        //     'subject_id'        => $request->subject_id,
        //     'teacher_id'        => $request->teacher_id,
        //     'date'              => $request->date,
        //     'type'              => $request->type,
        //     'start_time'        => $request->start_time,
        //     'end_time'          => $request->end_time,
        //     'term'              => $request->term,
        //     'session'           => $request->session,
        //     'tenant_id'         => auth()->user()->tenant_id,
        // ]);
        // ===== DEBUG END =====

        $request->validate([
            'class_id'   => 'required',
            'subject_id' => 'required',
            'teacher_id' => 'required',
            'date'       => 'required',
            'type'       => 'required',
            'start_time' => 'required',
            'end_time'   => 'required',
            'term'       => 'required',
            'session'    => 'required',
        ]);

        Test::create([
            'tenant_id'  => auth()->user()->tenant_id,
            'class_id'   => $request->class_id,
            'subject_id' => $request->subject_id,
            'teacher_id' => $request->teacher_id,
            'date'       => $request->date,
            'start_time' => $request->start_time,
            'end_time'   => $request->end_time,
            'term'       => $request->term,
            'session'    => $request->session,
            'type'       => $request->type,
        ]);

        return redirect()->route('tenant.test.index', $subdomain)
            ->with('success', 'Class Test Date Added');
    }

    public function edit($subdomain, $id)
    {
        $test = Test::findOrFail($id); // ✅ Fixed: was test:: (lowercase)
        $classes = SchoolClass::where('tenant_id', auth()->user()->tenant_id)->get();
        $subjects = Subject::where('tenant_id', auth()->user()->tenant_id)->get();
        $teachers = \App\Models\Teacher::where('tenant_id', auth()->user()->tenant_id)->get();

        return view('admin.test.edit', compact('test', 'classes', 'subjects', 'teachers', 'subdomain'));
    }

    public function update(Request $request, $subdomain, $id)
    {
        $request->validate([
            'class_id'   => 'required',
            'subject_id' => 'required',
            'teacher_id' => 'required',
            'date'       => 'required',
            'start_time' => 'required',
            'end_time'   => 'required',
            'term'       => 'required',
            'session'    => 'required',
            'type'       => 'required',
        ]);

        $test = Test::findOrFail($id);

        $test->update([
            'class_id'   => $request->class_id,
            'subject_id' => $request->subject_id,
            'teacher_id' => $request->teacher_id,
            'date'       => $request->date,
            'start_time' => $request->start_time,
            'end_time'   => $request->end_time,
            'term'       => $request->term,
            'session'    => $request->session,
            'type'       => $request->type,
        ]);

        return redirect()->route('tenant.test.index', $subdomain)
            ->with('success', 'Updated successfully');
    }

    public function destroy($subdomain, $id)
    {
        Test::findOrFail($id)->delete();

        return back()->with('success', 'Deleted successfully');
    }
}