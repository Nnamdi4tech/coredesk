<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Student;

class DashboardController extends Controller
{
    public function index($subdomain)
{
    $studentId = session('student_id');

    if (!$studentId) {
        return redirect()->route('student.login', $subdomain);
    }

    $tenantId = getSchoolIdFromSubdomain($subdomain);

    // ✅ Use tenant_id not subdomain column
    $student = Student::with(['schoolClass'])
        ->where('id', $studentId)
        ->where('tenant_id', $tenantId)
        ->first();

    if (!$student) {
        abort(403);
    }

    return view('student.dashboard', compact('student', 'subdomain'));
}  


}