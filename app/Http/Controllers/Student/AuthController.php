<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Student;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // 🔐 SHOW LOGIN FORM
    public function showLogin($subdomain)
    {
        return view('student.login', compact('subdomain'));
    }

    // 🔑 HANDLE LOGIN
    public function login(Request $request, $subdomain)
    {
        $request->validate([
            'student_id' => 'required',
            'password' => 'required',
        ]);

        $tenantId = getSchoolIdFromSubdomain($subdomain);

        $student = Student::where('student_id', $request->student_id)
        ->where('tenant_id', $tenantId)
        ->first();

        if (!$student || !Hash::check($request->password, $student->password)) {
            return back()->with('error', 'Invalid Student ID or Password');
        }

        // ✅ store session
        session([
            'student_id' => $student->id,
            'student' => $student,
            'school_id' => $student->school_id
        ]);

        return redirect()->route('student.dashboard', $subdomain);
    }

    // 🚪 LOGOUT - Allow both GET and POST
// 🚪 LOGOUT - Allow both GET and POST
public function logout($subdomain)
{
    session()->forget('student_id');
    
    $port = request()->getPort();
    
    // ✅ FIXED: Use coredesk.com.ng for production, fallback to .local for development
    $domain = app()->environment('production') ? 'coredesk.com.ng' : 'coredesk.local';
    $baseUrl = $port ? "http://{$subdomain}.{$domain}:{$port}" : "http://{$subdomain}.{$domain}";
    
    return redirect("{$baseUrl}/student/login");
}


}