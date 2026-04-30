<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Test;

class TestController extends Controller
{
    public function index($subdomain)
   {
    $student = currentStudent();

    $tests = Test::where('tenant_id', $student->tenant_id)
        ->where('class_id', $student->class_id)
        ->with('subject')
        ->orderBy('date')
        ->get();

    return view('student.tests.index', compact('tests', 'subdomain'));
   }



}


