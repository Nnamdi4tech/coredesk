<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Timetable;

class TimetableController extends Controller
{
    public function index(Request $request, $subdomain)
    {
        $teacher = auth()->user()->teacher;

        $query = Timetable::where('tenant_id', $teacher->tenant_id);

        // 🔍 FILTER: ONLY MY TIMETABLE
        if ($request->my == 1) {
            $query->where('teacher_id', $teacher->id);
        }

        // 🔍 OPTIONAL FILTERS
        if ($request->day) {
            $query->where('day', $request->day);
        }

        if ($request->term) {
            $query->where('term', $request->term);
        }

        if ($request->session) {
            $query->where('session', $request->session);
        }

        $timetables = $query->orderBy('day')->get();

        return view('teacher.timetable.index', compact('timetables', 'subdomain'));
    }
}