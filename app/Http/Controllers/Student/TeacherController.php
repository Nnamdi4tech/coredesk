<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Teacher;

class TeacherController extends Controller
{
    public function index($subdomain)
    {
        $student = currentStudent();

        if (!$student) {
            return redirect()->route('student.login', $subdomain);
        }

        // ✅ Get teachers teaching this student's class
        $teachers = Teacher::whereHas('subjects', function ($query) use ($student) {
            $query->where('teacher_subjects.class_id', $student->class_id);
        })
        ->with('user') // if teacher has user relationship
        ->distinct()
        ->get();

        return view('student.teachers.index', compact('teachers', 'student', 'subdomain'));
    }
}