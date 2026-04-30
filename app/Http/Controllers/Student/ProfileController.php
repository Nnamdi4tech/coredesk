<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;

class ProfileController extends Controller
{
    public function index($subdomain)
    {
        $student = currentStudent();

        if (!$student) {
            return redirect()->route('student.login', $subdomain);
        }

        return view('student.profile.index', compact('student', 'subdomain'));
    }
}