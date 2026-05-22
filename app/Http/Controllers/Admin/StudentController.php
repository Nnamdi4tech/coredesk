<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\SchoolClass;
use Illuminate\Support\Facades\Hash;
use App\Models\Tenant;

class StudentController extends Controller
{
    // 📄 LIST STUDENTS
    public function index($subdomain)
{
    $tenantId = auth()->user()->tenant_id;
    
    // Get all students
    $students = Student::where('tenant_id', $tenantId)
                   ->with(['schoolClass', 'teacher'])
                   ->latest()
                   ->paginate(10);
    
    // Get all classes for the filter dropdown
    $classes = SchoolClass::where('tenant_id', $tenantId)->get();
    
    // CARD 1: Total Students
    $totalStudents = Student::where('tenant_id', $tenantId)->count();
    
    
    // CARD 2: Male Students
    $maleStudents = Student::where('tenant_id', $tenantId)->where('gender', 'male')->count();
    
    // CARD 3: Female Students
    $femaleStudents = Student::where('tenant_id', $tenantId)->where('gender', 'female')->count();
    
    // CARD 4: New This Month
    $newThisMonth = Student::where('tenant_id', $tenantId)
                           ->whereMonth('created_at', now()->month)
                           ->whereYear('created_at', now()->year)
                           ->count();
    
    // Calculate percentages
    $malePercentage = $totalStudents > 0 ? round(($maleStudents / $totalStudents) * 100) : 0;
    $femalePercentage = $totalStudents > 0 ? round(($femaleStudents / $totalStudents) * 100) : 0;

    return view('admin.students.index', compact(
        'subdomain',
        'students',
        'classes',  // ← Add this
        'totalStudents',
        'maleStudents',
        'femaleStudents',
        'newThisMonth',
        'malePercentage',
        'femalePercentage'
    ));
}

    // ➕ CREATE FORM
public function create($subdomain)
{
    $teachers = Teacher::where('tenant_id', auth()->user()->tenant_id)->get();
    $classes = SchoolClass::where('tenant_id', auth()->user()->tenant_id)->get();
    
    // Generate initial Student ID
    $lastStudent = Student::where('tenant_id', auth()->user()->tenant_id)->latest()->first();
    if ($lastStudent && $lastStudent->student_id) {
        $lastNumber = (int) substr($lastStudent->student_id, -4);
        $nextNumber = $lastNumber + 1;
        $newNumber = str_pad($nextNumber, 4, '0', STR_PAD_LEFT);
        $generatedStudentId = 'ST-ID-' . date('Y') . '-' . $newNumber;
    } else {
        $generatedStudentId = 'ST-ID-' . date('Y') . '-0001';
    }

    return view('admin.students.create', compact('teachers', 'classes', 'subdomain', 'generatedStudentId'));
}
    

    // 💾 STORE STUDENT
    public function store(Request $request, $subdomain)
    {    
        // ✅ Plan limit check
        $tenant = app('tenant');
        if ($tenant->plan === 'free') {
        $count = Student::where('tenant_id', $tenant->id)->count();
        if ($count >= 3) {
            return back()->with('error', 'Free plan allows only 3 students. Upgrade your plan.');
          }
        }

        $request->validate([
            'name' => 'required',
            'password' => 'required|min:6',
            'teacher_id' => 'required|exists:teachers,id',
            'student_id' => 'required|unique:students,student_id,NULL,id,tenant_id,' . auth()->user()->tenant_id,
            'class_id' => 'required|exists:school_classes,id',
        ]);

        Student::create([
            'tenant_id' => auth()->user()->tenant_id,
            'teacher_id' => $request->teacher_id,
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'plain_password' => $request->password,   // ✅ ADD THIS
            'phone' => $request->phone,
            'gender' => $request->gender,
            'class_id' => $request->class_id,
            'student_id' => $request->student_id,
            
        ]);

        return redirect()->route('tenant.students.index', $subdomain)
            ->with('success', 'Student added successfully');
    }


    // 📄 GENERATE STUDENT ID
public function generateStudentId($subdomain)
{
    $lastStudent = Student::where('tenant_id', auth()->user()->tenant_id)->latest()->first();
    
    if ($lastStudent && $lastStudent->student_id) {
        // Extract the number from existing ID (e.g., ST-ID-2026-0001 -> 0001)
        $lastNumber = (int) substr($lastStudent->student_id, -4);
        $nextNumber = $lastNumber + 1;
        $newNumber = str_pad($nextNumber, 4, '0', STR_PAD_LEFT);
        $generatedStudentId = 'ST-ID-' . date('Y') . '-' . $newNumber;
    } else {
        $generatedStudentId = 'ST-ID-' . date('Y') . '-0001';
    }
    
    return response()->json(['student_id' => $generatedStudentId]);
}

// 📝 EDIT FORM
public function edit($subdomain, $id)
{
    $student = Student::where('tenant_id', auth()->user()->tenant_id)
                      ->where('id', $id)
                      ->firstOrFail();
    
    $teachers = Teacher::where('tenant_id', auth()->user()->tenant_id)->get();
    $classes = SchoolClass::where('tenant_id', auth()->user()->tenant_id)->get();
    
    return view('admin.students.edit', compact('subdomain', 'student', 'teachers', 'classes'));
}

// 💾 UPDATE STUDENT
public function update(Request $request, $subdomain, $id)
{
    $student = Student::where('tenant_id', auth()->user()->tenant_id)
                      ->where('id', $id)
                      ->firstOrFail();
    
    $request->validate([
        'name' => 'required',
        'teacher_id' => 'required|exists:teachers,id',
        'student_id' => 'required|unique:students,student_id,' . $student->id . ',id,tenant_id,' . auth()->user()->tenant_id,
        'class_id' => 'required|exists:school_classes,id',
        'password' => 'nullable|min:6',
    ]);
    
    $updateData = [
        'teacher_id' => $request->teacher_id,
        'name' => $request->name,
        'email' => $request->email,
        'phone' => $request->phone,
        'gender' => $request->gender,
        'class_id' => $request->class_id,
        'student_id' => $request->student_id,
        'plain_password' => $request->filled('password') ? $request->password : $student->plain_password,
    ];
    
    if ($request->filled('password')) {
        $updateData['password'] = Hash::make($request->password);
    }
    
    $student->update($updateData);
    
    return redirect()->route('tenant.students.index', $subdomain)
        ->with('success', 'Student updated successfully');
}

// 🗑️ DELETE STUDENT
public function destroy($subdomain, $id)
{
    $student = Student::where('tenant_id', auth()->user()->tenant_id)
                      ->where('id', $id)
                      ->firstOrFail();
    
    $student->delete();
    
    return redirect()->route('tenant.students.index', $subdomain)
        ->with('success', 'Student deleted successfully'); 
}





}