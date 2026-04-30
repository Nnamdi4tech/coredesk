<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Teacher;
use App\Models\Subject;
use App\Models\Student;
use App\Models\SchoolClass;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class TeacherController extends Controller
{
    public function index($subdomain)
    {
        $tenantId = auth()->user()->tenant_id;
        
        // Get all teachers for this tenant
        $teachers = Teacher::where('tenant_id', $tenantId)->latest()->paginate(10);

        // For each teacher, get their assigned classes (for the table display)
    foreach ($teachers as $teacher) {
        // Get unique class names assigned to this teacher through students
        $assignedClassNames = Student::where('tenant_id', $tenantId)
            ->where('teacher_id', $teacher->id)
            ->with('schoolClass')
            ->get()
            ->pluck('schoolClass.name')
            ->unique()
            ->filter()
            ->implode(', ');
        
        $teacher->assigned_classes = $assignedClassNames ?: 'Not assigned';
    }
        
        // CARD 1: Total Teachers
        $totalTeachers = $teachers->count();
        
        // CARD 2: Active Teachers
        $activeTeachers = Teacher::where('tenant_id', $tenantId)->where('status', 'active')->count();
        
        // CARD 3: On Leave
        $onLeaveTeachers = Teacher::where('tenant_id', $tenantId)->where('status', 'on_leave')->count();
        
        // CARD 4: Unique Departments
        $uniqueDepartments = Teacher::where('tenant_id', $tenantId)
                                    ->whereNotNull('department')
                                    ->where('department', '!=', '')
                                    ->distinct()
                                    ->count('department');
        
        // CARD 5: New This Month (teachers joined in current month)
        $newThisMonth = Teacher::where('tenant_id', $tenantId)
                               ->whereMonth('created_at', now()->month)
                               ->whereYear('created_at', now()->year)
                               ->count();
        
        // CARD 6: Average Performance (calculate from results if available, or use placeholder)
        // If you have a results table with scores, calculate average. For now, calculate based on teachers with subjects
        $teachersWithSubjects = DB::table('teacher_subjects')
                                  ->where('tenant_id', $tenantId)
                                  ->distinct('teacher_id')
                                  ->count('teacher_id');
        $avgPerformance = $totalTeachers > 0 ? round(($teachersWithSubjects / $totalTeachers) * 100) : 0;
        
        // CARD 7: Unique Subjects Taught (distinct subjects assigned to teachers in this tenant)
        $subjectsTaught = DB::table('teacher_subjects')
                            ->join('subjects', 'teacher_subjects.subject_id', '=', 'subjects.id')
                            ->where('teacher_subjects.tenant_id', $tenantId)
                            ->distinct()
                            ->count('teacher_subjects.subject_id');
        
        // CARD 8: Unique Classes Assigned (distinct classes assigned to teachers)
        $classesAssigned = DB::table('teacher_subjects')
                            ->where('tenant_id', $tenantId)
                            ->distinct()
                            ->count('class_id');
        
        // Calculate percentages
        $activePercentage = $totalTeachers > 0 ? round(($activeTeachers / $totalTeachers) * 100) : 0;
        $onLeavePercentage = $totalTeachers > 0 ? round(($onLeaveTeachers / $totalTeachers) * 100) : 0;
        $deptPercentage = $uniqueDepartments > 0 ? min(round(($uniqueDepartments / 10) * 100), 100) : 0;

        return view('admin.teachers.index', compact(
            'subdomain', 
            'teachers', 
            'totalTeachers', 
            'activeTeachers', 
            'onLeaveTeachers', 
            'uniqueDepartments',
            'newThisMonth',
            'avgPerformance',
            'subjectsTaught',
            'classesAssigned',
            'activePercentage',
            'onLeavePercentage',
            'deptPercentage'
        ));
    }

     

    public function create($subdomain)
    {
        return view('admin.teachers.create', compact('subdomain'));
    }

    public function store(Request $request, $subdomain)
{
    $tenant = app('tenant');

if ($tenant->plan === 'free') {
    // ✅ Use auth()->user()->tenant_id directly — guaranteed to match the teachers table
    $count = Teacher::where('tenant_id', auth()->user()->tenant_id)->count();

    if ($count >= 2) {
        return back()->with('error', 'Free plan allows only 2 teachers. Upgrade your plan.');
    }
}

    // ✅ MANUAL CHECK: Does this email already exist in THIS tenant?
    $tenantId = auth()->user()->tenant_id;

$existingUser = User::where('email', $request->email)
                    ->where('tenant_id', $tenantId)
                    ->exists();

if ($existingUser) {
    return back()->withInput()->with('error', 'This email is already registered in your school. Please use a different email.');
}

    // ✅ Validate other fields
    $request->validate([
        'name'            => 'required|string|max:255',
        'phone'           => 'nullable|string|max:20',
        'gender'          => 'nullable|in:male,female',
        'dob'             => 'nullable|date',
        'address'         => 'nullable|string',
        'password'        => 'required|string|min:6',
        'staff_id'        => 'required|string|max:255|unique:teachers,staff_id',
        'employee_id'     => 'nullable|string|max:255',
        'employment_date' => 'nullable|date',
        'employment_type' => 'nullable|in:full_time,part_time,contract,volunteer',
        'department'      => 'nullable|string|max:255',
        'position'        => 'nullable|string|max:255',
        'subject'         => 'nullable|string|max:255',
        'status'          => 'nullable|in:active,inactive,on_leave,suspended',
    ]);

    // ✅ Create USER login account
    // Replace the User::create and Teacher::create blocks with this:
DB::transaction(function () use ($request) {
    $user = User::create([
        'name'      => $request->name,
        'email'     => $request->email,
        'password'  => Hash::make($request->password),
        'tenant_id' => auth()->user()->tenant_id,
        'role'      => 'teacher',
    ]);

    Teacher::create([
        'tenant_id'       => auth()->user()->tenant_id,
        'user_id'         => $user->id,
        'name'            => $request->name,
        'email'           => $request->email,
        'phone'           => $request->phone,
        'gender'          => $request->gender,
        'dob'             => $request->dob,
        'address'         => $request->address,
        'staff_id'        => $request->staff_id,
        'employee_id'     => $request->employee_id,
        'employment_date' => $request->employment_date,
        'employment_type' => $request->employment_type,
        'department'      => $request->department,
        'position'        => $request->position   ?? 'teacher',
        'subject'         => $request->subject,
        'status'          => $request->status     ?? 'active',
        'plain_password'  => $request->password,
    ]);
});

return redirect()
    ->route('tenant.teachers.index', $subdomain)
    ->with('success', 'Teacher added successfully.');
}

    public function generateStaffId($subdomain)
  {
    $lastTeacher = Teacher::where('tenant_id', auth()->user()->tenant_id)->latest()->first();
    if ($lastTeacher && $lastTeacher->staff_id) {
        $lastNumber = (int) substr($lastTeacher->staff_id, -4);
        $nextNumber = $lastNumber + 1;
    } else {
        $nextNumber = 1;
    }
    
    return response()->json(['nextNumber' => $nextNumber]);
 }



 /**
 * Show the form for editing the specified teacher.
 */
public function edit($subdomain, $id)
{
    $teacher = Teacher::where('tenant_id', auth()->user()->tenant_id)
                      ->where('id', $id)
                      ->firstOrFail();
    
    return view('admin.teachers.edit', compact('subdomain', 'teacher'));
}

/**
 * Update the specified teacher.
 */
public function update(Request $request, $subdomain, $id)
{
    $teacher = Teacher::where('tenant_id', auth()->user()->tenant_id)
                      ->where('id', $id)
                      ->firstOrFail();
    
    // Find the associated user
    $user = User::where('id', $teacher->user_id)
                ->where('tenant_id', auth()->user()->tenant_id)
                ->firstOrFail();
    
    // ✅ Validate fields
    $request->validate([
        'name'            => 'required|string|max:255',
        'phone'           => 'nullable|string|max:20',
        'gender'          => 'nullable|in:male,female',
        'dob'             => 'nullable|date',
        'address'         => 'nullable|string',
        'password'        => 'nullable|string|min:6',
        'staff_id'        => 'required|string|max:255|unique:teachers,staff_id,' . $teacher->id,
        'employee_id'     => 'nullable|string|max:255',
        'employment_date' => 'nullable|date',
        'employment_type' => 'nullable|in:full_time,part_time,contract,volunteer',
        'department'      => 'nullable|string|max:255',
        'position'        => 'nullable|string|max:255',
        'subject'         => 'nullable|string|max:255',
        'status'          => 'nullable|in:active,inactive,on_leave,suspended',
    ]);
    
    // ✅ Update USER account (if password is provided)
    $userData = [
        'name'  => $request->name,
        'email' => $request->email,
    ];
    
    if ($request->filled('password')) {
        $userData['password'] = Hash::make($request->password);
    }
    
    $user->update($userData);
    
    // ✅ Update TEACHER profile
    $teacher->update([
        'name'            => $request->name,
        'email'           => $request->email,
        'phone'           => $request->phone,
        'gender'          => $request->gender,
        'dob'             => $request->dob,
        'address'         => $request->address,
        'staff_id'        => $request->staff_id,
        'employee_id'     => $request->employee_id,
        'employment_date' => $request->employment_date,
        'employment_type' => $request->employment_type,
        'department'      => $request->department,
        'position'        => $request->position,
        'subject'         => $request->subject,
        'status'          => $request->status,
        'plain_password' => $request->filled('password') ? $request->password : $teacher->plain_password,
    ]);
    
    return redirect()
        ->route('tenant.teachers.index', $subdomain)
        ->with('success', 'Teacher updated successfully.');
}

/**
 * Delete the specified teacher.
 */
public function destroy($subdomain, $id)
{
    $teacher = Teacher::where('tenant_id', auth()->user()->tenant_id)
                      ->where('id', $id)
                      ->firstOrFail();
    
    // Delete the associated user
    $user = User::where('id', $teacher->user_id)
                ->where('tenant_id', auth()->user()->tenant_id)
                ->first();
    
    if ($user) {
        $user->delete();
    }
    
    $teacher->delete();
    
    return redirect()
        ->route('tenant.teachers.index', $subdomain)
        ->with('success', 'Teacher deleted successfully.');
}






}