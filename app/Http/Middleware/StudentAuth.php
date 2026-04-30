<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class StudentAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    
    public function handle($request, Closure $next)
{
    $studentId = session('student_id');

if (!$studentId) {
    return redirect()->route('student.login', $request->route('subdomain'));
}

$student = \App\Models\Student::where('id', $studentId)
    ->where('tenant_id', getSchoolIdFromSubdomain($request->route('subdomain')))
    ->first();

if (!$student) {
    abort(403);
}

    return $next($request);
}









}
