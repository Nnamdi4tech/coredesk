<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Result;
use App\Models\Student;
use App\Models\SchoolClass;

class ResultController extends Controller
{
    public function index($subdomain)
    {
        $student = currentStudent();

        if (!$student) {
            return redirect()->route('student.login', $subdomain);
        }

        // 👇 Get filters
        $term = request('term');
        $session = request('session');
        $classId = request('class_id');

        // ✅ Base query (secured with tenant)
        $query = Result::with(['subject', 'schoolClass'])
            ->where('student_id', $student->id)
            ->where('tenant_id', $student->tenant_id) // ✅ safety layer
            ->where('submitted', true);

        // 👇 Apply filters
        if ($term) {
            $query->where('term', $term);
        }

        if ($session) {
            $query->where('session', $session);
        }

        if ($classId) {
            $query->where('class_id', $classId);
        }

        $results = $query->get();

        // 👇 dropdowns (tenant-safe)
        $terms = Result::where('student_id', $student->id)
            ->where('tenant_id', $student->tenant_id)
            ->pluck('term')
            ->unique()
            ->values();

        $sessions = Result::where('student_id', $student->id)
            ->where('tenant_id', $student->tenant_id)
            ->pluck('session')
            ->unique()
            ->values();

        // ✅ Classes for filter (tenant-safe)
        $classes = SchoolClass::where('tenant_id', $student->tenant_id)->get();

        return view('student.results.index', compact(
            'results',
            'student',
            'subdomain',
            'terms',
            'sessions',
            'classes'
        ));
    }
}