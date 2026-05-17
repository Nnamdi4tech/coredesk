<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\TeacherController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Admin\SubjectController;
use App\Http\Controllers\Admin\StudentController;
use App\Http\Controllers\Teacher\StudentController as TeacherStudentController;
use App\Http\Controllers\Teacher\ResultController;
use App\Http\Controllers\Teacher\AttendanceController;
use App\Http\Controllers\Teacher\ClassesController;
use App\Http\Controllers\Teacher\TimetableController as TeacherTimetableController;
use App\Http\Controllers\Admin\AdminResultController;
use App\Http\Controllers\Admin\ClassController;
use App\Http\Controllers\Student\AuthController;
use App\Http\Controllers\Student\DashboardController as StudentDashboardController;
use App\Http\Controllers\Student\ResultController as StudentResultController;
use App\Http\Controllers\Student\SubjectController as StudentSubjectController;
use App\Http\Controllers\Student\TeacherController as StudentTeacherController;
use App\Http\Controllers\Student\ProfileController;
use App\Http\Controllers\Student\TimetableController;
use App\Http\Controllers\Student\TestController;
use App\Http\Controllers\Student\ExamController;
use App\Http\Controllers\Admin\TimetableController as AdminTimetableController;
use App\Http\Controllers\Admin\TestController as AdminTestController;
use App\Http\Controllers\Admin\ExamController as AdminExamController;
use App\Http\Controllers\Admin\BillingController;


Route::domain('{subdomain}.coredesk.com.ng')
    ->middleware(['web', 'tenant', 'tenant.status'])
    ->group(function () {

    // ================= AUTH =================
    Route::get('/login', [AuthenticatedSessionController::class, 'create'])
        ->middleware('guest')
        ->name('tenant.login');

    Route::post('/login', [AuthenticatedSessionController::class, 'store'])
        ->middleware('guest');

    Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
        ->middleware('auth')
        ->name('tenant.logout');

    // ================= ROOT REDIRECT =================
    // ================= ROOT REDIRECT =================
Route::get('/', function () {
    // Get tenant from the middleware
    $tenant = app('tenant');
    
    // If tenant is inactive, the middleware should have already caught this
    // But just in case, check again
    if ($tenant && !$tenant->is_active) {
        return response(\App\Http\Middleware\CheckTenantStatus::getInactivePageStatic(), 403);
    }
    
    if (!auth()->check()) {
        $host = request()->getHost();
        $port = request()->getPort();
        $baseUrl = $port ? "http://{$host}:{$port}" : "http://{$host}";
        return redirect("{$baseUrl}/login");
    }
    
    $role = auth()->user()->role;
    return match($role) {
        'super_admin' => redirect('/admin/dashboard'),
        'teacher'     => redirect('/teacher/dashboard'),
        'accountant'  => redirect('/finance/dashboard'),
        default       => abort(403, 'Unknown role.')
    };
});

    // ================= PROTECTED ROUTES =================
    Route::middleware(['auth'])->group(function () {

        // DASHBOARDS
        Route::get('/admin/dashboard', [DashboardController::class, 'index'])
        ->name('tenant.admin.dashboard');

        Route::get('/teacher/dashboard', function () {
            if (auth()->user()->role !== 'teacher') abort(403);
            return view('teacher.dashboard');
        })->name('tenant.teacher.dashboard');

        Route::get('/finance/dashboard', function () {
            if (auth()->user()->role !== 'accountant') abort(403);
            return view('finance.dashboard');
        })->name('tenant.finance.dashboard');

        // TEACHERS
        Route::get('/admin/teachers', [TeacherController::class, 'index'])->name('tenant.teachers.index');
        Route::get('/admin/teachers/create', [TeacherController::class, 'create'])->name('tenant.teachers.create');
        Route::get('/admin/teachers/edit/{id}', [TeacherController::class, 'edit'])->name('tenant.teachers.edit');
        Route::put('/admin/teachers/update/{id}', [TeacherController::class, 'update'])->name('tenant.teachers.update');
        Route::delete('/admin/teachers/delete/{id}', [TeacherController::class, 'destroy'])->name('tenant.teachers.delete');
        // Add this inside your tenant routes group
        Route::get('/teachers/generate-staff-id', [TeacherController::class, 'generateStaffId'])->name('tenant.teachers.generate-staff-id');
        Route::post('/admin/teachers', [TeacherController::class, 'store'])->name('tenant.teachers.store');

        // SUBJECTS
        Route::get('/admin/subjects', [SubjectController::class, 'index'])->name('tenant.subjects.index');
        Route::get('/admin/subjects/create', [SubjectController::class, 'create'])->name('tenant.subjects.create');
        Route::post('/admin/subjects', [SubjectController::class, 'store'])->name('tenant.subjects.store');
        Route::get('/admin/subjects/edit/{id}', [SubjectController::class, 'edit'])->name('tenant.subjects.edit');
        Route::put('/admin/subjects/update/{id}', [SubjectController::class, 'update'])->name('tenant.subjects.update');
        Route::delete('/admin/subjects/delete/{id}', [SubjectController::class, 'destroy'])->name('tenant.subjects.destroy');

        // STUDENTS
        Route::get('/admin/students', [StudentController::class, 'index'])->name('tenant.students.index');
        Route::get('/admin/students/create', [StudentController::class, 'create'])->name('tenant.students.create');
        Route::post('/admin/students', [StudentController::class, 'store'])->name('tenant.students.store');
        Route::get('/students/generate-student-id', [StudentController::class, 'generateStudentId'])->name('tenant.students.generate-student-id');
        // STUDENTS (add these with your existing student routes)
        Route::get('/admin/students/edit/{id}', [StudentController::class, 'edit'])->name('tenant.students.edit');
        Route::put('/admin/students/update/{id}', [StudentController::class, 'update'])->name('tenant.students.update');
        Route::delete('/admin/students/delete/{id}', [StudentController::class, 'destroy'])->name('tenant.students.delete');

        // RESULTS
        Route::get('/admin/results', [\App\Http\Controllers\Admin\AdminResultController::class, 'index'])->name('tenant.admin.results.index');
        Route::get('/admin/results/{subject}/{class}', [AdminResultController::class, 'show'])->name('tenant.admin.results.show');
        Route::post('/admin/results/{subject}/{class}/approve', [AdminResultController::class, 'approve'])->name('tenant.admin.results.approve');
        Route::post('/admin/results/{subject}/{class}/reject', [AdminResultController::class, 'reject'])->name('tenant.admin.results.reject');
        Route::post('/admin/results/approve-one/{result}', [AdminResultController::class, 'approveOne'])->name('tenant.admin.results.approve.one');
        Route::post('/admin/results/reject-one/{result}', [AdminResultController::class, 'rejectOne'])->name('tenant.admin.results.reject.one');
        Route::get('/admin/results/report', [AdminResultController::class, 'reportFilter'])->name('tenant.admin.results.filter');
        Route::get('/admin/results/student', [AdminResultController::class, 'studentReport'])->name('tenant.admin.results.student');
        Route::get('/admin/results/class', [AdminResultController::class, 'classResult'])->name('tenant.admin.results.class');

        // CLASSES
        Route::get('/admin/classes', [ClassController::class, 'index'])->name('tenant.classes.index');
        Route::get('/admin/classes/create', [ClassController::class, 'create'])->name('tenant.classes.create');
        Route::post('/admin/classes/store', [ClassController::class, 'store'])->name('tenant.classes.store');

        // TIMETABLE
       Route::get('/admin/timetable', [AdminTimetableController::class, 'index'])->name('tenant.timetable.index');
       Route::get('/admin/timetable/create', [AdminTimetableController::class, 'create'])->name('tenant.timetable.create');
       Route::post('/admin/timetable/store', [AdminTimetableController::class, 'store'])->name('tenant.timetable.store');
       Route::get('/admin/timetable/edit/{id}', [AdminTimetableController::class, 'edit'])->name('tenant.timetable.edit');
       Route::post('/admin/timetable/update/{id}', [AdminTimetableController::class, 'update'])->name('tenant.timetable.update');
       Route::get('/admin/timetable/delete/{id}', [AdminTimetableController::class, 'destroy'])->name('tenant.timetable.delete');

        // TEST
        Route::prefix('test')->group(function () {
            Route::get('/', [AdminTestController::class, 'index'])->name('tenant.test.index');
            Route::get('/create', [AdminTestController::class, 'create'])->name('tenant.test.create');
            Route::post('/store', [AdminTestController::class, 'store'])->name('tenant.test.store');
            Route::get('/edit/{id}', [AdminTestController::class, 'edit'])->name('tenant.test.edit');
            Route::post('/update/{id}', [AdminTestController::class, 'update'])->name('tenant.test.update');
            Route::get('/delete/{id}', [AdminTestController::class, 'destroy'])->name('tenant.test.delete');
        });

        // EXAM
        Route::prefix('exam')->group(function () {
            Route::get('/', [AdminExamController::class, 'index'])->name('tenant.exam.index');
            Route::get('/create', [AdminExamController::class, 'create'])->name('tenant.exam.create');
            Route::post('/store', [AdminExamController::class, 'store'])->name('tenant.exam.store');
            Route::get('/edit/{id}', [AdminExamController::class, 'edit'])->name('tenant.exam.edit');
            Route::post('/update/{id}', [AdminExamController::class, 'update'])->name('tenant.exam.update');
            Route::get('/delete/{id}', [AdminExamController::class, 'destroy'])->name('tenant.exam.delete');
        });

        //Billing Page
        Route::get('/admin/billing/{subdomain?}', [BillingController::class, 'index'])
        ->name('tenant.billing');
         
        // ================= Teachers ROUTES start here =================
        // TEACHER STUDENTS
        Route::get('/teacher/students', [TeacherStudentController::class, 'index'])->name('tenant.teacher.students');

        // TEACHER RESULTS
        Route::get('/teacher/results/bulk', [ResultController::class, 'bulk'])->name('tenant.teacher.results.bulk');
        Route::post('/teacher/results/bulk', [ResultController::class, 'bulkStore'])->name('tenant.teacher.results.bulk.store');
        Route::post('/teacher/results/submit/{subject}', [ResultController::class, 'submit'])->name('tenant.teacher.results.submit');
        Route::get('/teacher/results', [ResultController::class, 'index'])->name('tenant.teacher.results.index');
        Route::get('/teacher/results/create', [ResultController::class, 'create'])->name('tenant.teacher.results.create');
        Route::post('/teacher/results', [ResultController::class, 'store'])->name('tenant.teacher.results.store');
        Route::get('/teacher/results/{student}/edit', [ResultController::class, 'edit'])->name('tenant.teacher.results.edit');
        Route::post('/teacher/results/{student}', [ResultController::class, 'update'])->name('tenant.teacher.results.update');

        
        // Teacher Classes
        Route::get('/teacher/classes', [\App\Http\Controllers\Teacher\ClassesController::class, 'index'])->name('tenant.teacher.classes.index');
        // TEACHER TIMETABLE
        Route::get('/teacher/timetable', [TeacherTimetableController::class, 'index'])->name('teacher.timetable');
        // TEACHER attendance
        Route::get('/teacher/attendance', [AttendanceController::class, 'index'])->name('teacher.timetable');
        
        // Teacher Attendance
        Route::get('/teacher/attendance', [AttendanceController::class, 'index'])->name('teacher.attendance.index');
        Route::post('/teacher/attendance/store', [AttendanceController::class, 'store'])->name('teacher.attendance.store');
        Route::get('/teacher/attendance/view', [AttendanceController::class, 'viewRecord'])->name('teacher.attendance.view');

        // ================= Teachers ROUTES ends here =================
    }); // end auth middleware

    // ================= STUDENT ROUTES =================
    Route::prefix('student')->group(function () {

        Route::get('/login', [AuthController::class, 'showLogin'])->name('student.login');
        Route::post('/login', [AuthController::class, 'login'])->name('student.login.post');

        Route::middleware(\App\Http\Middleware\StudentAuth::class)->group(function () {
            Route::get('/dashboard', [StudentDashboardController::class, 'index'])->name('student.dashboard');
            Route::get('/results', [StudentResultController::class, 'index'])->name('student.results.index');
            Route::get('/subjects', [StudentSubjectController::class, 'index'])->name('student.subjects');
            Route::get('/teachers', [StudentTeacherController::class, 'index'])->name('student.teachers');
            Route::get('/profile', [ProfileController::class, 'index'])->name('student.profile');
            Route::get('/timetable', [TimetableController::class, 'index'])->name('student.timetable');
            Route::get('/tests', [TestController::class, 'index'])->name('student.tests');
            Route::get('/exams', [ExamController::class, 'index'])->name('student.exams');
            Route::post('/logout', [AuthController::class, 'logout'])->name('student.logout');
            
        });

    });

}); // end domain group