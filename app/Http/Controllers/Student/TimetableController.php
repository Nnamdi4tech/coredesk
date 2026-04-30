<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Timetable;

class TimetableController extends Controller
{
    public function index($subdomain)
    {
        $student = currentStudent();

        if (!$student) {
            return redirect()->route('student.login', $subdomain);
        }

        $timetable = Timetable::with(['subject', 'teacher'])
            ->where('class_id', $student->class_id)
            ->orderBy('day')
            ->orderBy('start_time')
            ->get()
            ->groupBy('day');

        return view('student.timetable.index', compact('timetable', 'subdomain'));
    }
}