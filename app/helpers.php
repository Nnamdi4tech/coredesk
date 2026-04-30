<?php

use App\Models\Student;

if (!function_exists('currentStudent')) {
    function currentStudent()
    {
        return Student::find(session('student_id'));
    }

    function getSchoolIdFromSubdomain($subdomain)
{
    return \App\Models\Tenant::where('subdomain', $subdomain)->value('id');
}


} 