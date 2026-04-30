<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\Teacher;

class StudentController extends Controller
{
    public function index($subdomain)
    {
        // 🔥 Get logged-in teacher
        $teacher = Teacher::where('user_id', auth()->id())->first();

        // 🔥 Get only this teacher's students
        $students = Student::where('teacher_id', $teacher->id)->get();

        return view('teacher.students.index', compact('students', 'subdomain'));
    }
}