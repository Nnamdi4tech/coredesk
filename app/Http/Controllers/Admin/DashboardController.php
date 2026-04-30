<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Teacher;
use App\Models\Student;
use App\Models\SchoolClass;
use App\Models\Subject;

class DashboardController extends Controller
{
    public function index($subdomain) 
    {
        if (auth()->user()->role !== 'super_admin') abort(403);

        $tenantId = auth()->user()->tenant_id;

        // Current counts
        $totalTeachers = Teacher::where('tenant_id', $tenantId)->count();
        $totalStudents  = Student::where('tenant_id', $tenantId)->count();
        $totalClasses   = SchoolClass::where('tenant_id', $tenantId)->count();
        $totalSubjects  = Subject::where('tenant_id', $tenantId)->count();

        // Last month counts
        $lastMonth = now()->subMonth();

        $lastTeachers = Teacher::where('tenant_id', $tenantId)->whereMonth('created_at', $lastMonth->month)->whereYear('created_at', $lastMonth->year)->count();
        $lastStudents  = Student::where('tenant_id', $tenantId)->whereMonth('created_at', $lastMonth->month)->whereYear('created_at', $lastMonth->year)->count();
        $lastClasses   = SchoolClass::where('tenant_id', $tenantId)->whereMonth('created_at', $lastMonth->month)->whereYear('created_at', $lastMonth->year)->count();
        $lastSubjects  = Subject::where('tenant_id', $tenantId)->whereMonth('created_at', $lastMonth->month)->whereYear('created_at', $lastMonth->year)->count();

        // Growth helper
        $growth = function ($current, $last) {
            if ($last == 0) return $current > 0 ? '+100%' : '0%';
            $percent = (($current - $last) / $last) * 100;
            return ($percent >= 0 ? '+' : '') . round($percent) . '%';
        };

        $teacherGrowth = $growth($totalTeachers, $lastTeachers);
        $studentGrowth  = $growth($totalStudents, $lastStudents);
        $classGrowth    = $growth($totalClasses, $lastClasses);
        $subjectGrowth  = $growth($totalSubjects, $lastSubjects);

        return view('admin.dashboard', compact(
            'totalTeachers', 'totalStudents', 'totalClasses', 'totalSubjects',
            'teacherGrowth', 'studentGrowth', 'classGrowth', 'subjectGrowth'
        ));
    }
}