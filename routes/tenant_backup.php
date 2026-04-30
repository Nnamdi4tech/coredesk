<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\TeacherController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Admin\SubjectController;
use App\Http\Controllers\Admin\StudentController;
use App\Http\Controllers\Teacher\StudentController as TeacherStudentController;
use App\Http\Controllers\Teacher\ResultController;
use App\Http\Controllers\Teacher\TimetableController as TeacherTimetableController ;
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
use App\Http\Controllers\Admin\TimetableController as AdminTimetableController ;
use App\Http\Controllers\Admin\TestController as AdminTestController ;
use App\Http\Controllers\Admin\ExamController as AdminExamController ;



// ✅ Login routes for subdomain
Route::get('/login', [AuthenticatedSessionController::class, 'create'])
    ->middleware('guest')
    ->name('tenant.login');

Route::post('/login', [AuthenticatedSessionController::class, 'store'])
    ->middleware('guest');

Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
    ->middleware('auth')
    ->name('tenant.logout');

// Root redirect
Route::get('/', function () {
    if (!auth()->check()) {
        $host = request()->getHost();
        return redirect("http://{$host}:8000/login");
    }

    $role = auth()->user()->role;

    return match($role) {
        'super_admin' => redirect('/admin/dashboard'),
        'teacher'     => redirect('/teacher/dashboard'),
        'accountant'  => redirect('/finance/dashboard'),
        default       => abort(403, 'Unknown role.')
    };
});



Route::middleware(['auth'])->group(function () {

    // SUPER ADMIN DASHBOARD
    Route::get('/admin/dashboard', function () {
        if (auth()->user()->role !== 'super_admin') {
            abort(403);
        }
        return view('admin.dashboard');
    })->name('tenant.admin.dashboard');

    // TEACHER DASHBOARD
    Route::get('/teacher/dashboard', function () {
        if (auth()->user()->role !== 'teacher') {
            abort(403);
        }
        return view('teacher.dashboard');
    })->name('tenant.teacher.dashboard');

    // ACCOUNTANT DASHBOARD
    Route::get('/finance/dashboard', function () {
        if (auth()->user()->role !== 'accountant') {
            abort(403);
        }
        return view('finance.dashboard');
    })->name('tenant.finance.dashboard');

    // Teacher Management Routes
    Route::get('/admin/teachers', [TeacherController::class, 'index'])->name('tenant.teachers.index');
    Route::get('/admin/teachers/create', [TeacherController::class, 'create'])->name('tenant.teachers.create');
    Route::post('/admin/teachers', [TeacherController::class, 'store'])->name('tenant.teachers.store');


    // Subject Management Routes
    Route::get('/admin/subjects', [SubjectController::class, 'index'])->name('tenant.subjects.index');
    Route::get('/admin/subjects/create', [SubjectController::class, 'create'])->name('tenant.subjects.create');
    Route::post('/admin/subjects', [SubjectController::class, 'store'])->name('tenant.subjects.store');


    // STUDENTS
Route::get('/admin/students', [StudentController::class, 'index'])->name('tenant.students.index');
Route::get('/admin/students/create', [StudentController::class, 'create'])->name('tenant.students.create');
Route::post('/admin/students', [StudentController::class, 'store'])->name('tenant.students.store');

// ADMIN RESULT REVIEW 
Route::get('/admin/results', [\App\Http\Controllers\Admin\AdminResultController::class, 'index'])
    ->name('tenant.admin.results.index');

// ✅ SHOW - requires both subject and class
Route::get('/admin/results/{subject}/{class}', 
    [AdminResultController::class, 'show'])
    ->name('tenant.admin.results.show');

// ✅ APPROVE ALL - requires both subject and class
Route::post('/admin/results/{subject}/{class}/approve', 
    [AdminResultController::class, 'approve'])
    ->name('tenant.admin.results.approve');

// ✅ REJECT ALL - requires both subject and class
Route::post('/admin/results/{subject}/{class}/reject', 
    [AdminResultController::class, 'reject'])
    ->name('tenant.admin.results.reject');

// ✅ APPROVE SINGLE STUDENT - uses result ID (already unique)
Route::post('/admin/results/approve-one/{result}', 
    [AdminResultController::class, 'approveOne'])
    ->name('tenant.admin.results.approve.one');

// ✅ REJECT SINGLE STUDENT - uses result ID (already unique)
Route::post('/admin/results/reject-one/{result}', 
    [AdminResultController::class, 'rejectOne'])
    ->name('tenant.admin.results.reject.one');

    // ✅ REPORT FILTER PAGE
Route::get('/admin/results/report', 
    [AdminResultController::class, 'reportFilter'])
    ->name('tenant.admin.results.filter');

// ✅ FINAL REPORT 
Route::get('/admin/results/student', 
    [AdminResultController::class, 'studentReport'])
    ->name('tenant.admin.results.student');

    Route::get('/admin/results/class', 
    [AdminResultController::class, 'classResult']
)->name('tenant.admin.results.class');

    // classes
Route::get('/admin/classes', [ClassController::class, 'index'])->name('tenant.classes.index');
Route::get('/admin/classes/create', [ClassController::class, 'create'])->name('tenant.classes.create');
Route::post('/admin/classes/store', [ClassController::class, 'store'])->name('tenant.classes.store');


//Timetable
Route::prefix('timetable')->group(function () {
    Route::get('/{subdomain?}', [AdminTimetableController::class, 'index'])->name('tenant.timetable.index');
    Route::get('/create/{subdomain?}', [AdminTimetableController::class, 'create'])->name('tenant.timetable.create');
    Route::post('/store/{subdomain?}', [AdminTimetableController::class, 'store'])->name('tenant.timetable.store');
    Route::get('/edit/{id}/{subdomain?}', [AdminTimetableController::class, 'edit'])->name('tenant.timetable.edit');
    Route::post('/update/{id}/{subdomain?}', [AdminTimetableController::class, 'update'])->name('tenant.timetable.update');
    Route::get('/delete/{id}/{subdomain?}', [AdminTimetableController::class, 'destroy'])->name('tenant.timetable.delete');
});

//Test
Route::prefix('test')->group(function () {
    Route::get('/', [AdminTestController::class, 'index'])->name('tenant.test.index');
    Route::get('/create', [AdminTestController::class, 'create'])->name('tenant.test.create');
    Route::post('/store', [AdminTestController::class, 'store'])->name('tenant.test.store');
    Route::get('/edit/{id}', [AdminTestController::class, 'edit'])->name('tenant.test.edit');
    Route::post('/update/{id}', [AdminTestController::class, 'update'])->name('tenant.test.update');
    Route::get('/delete/{id}', [AdminTestController::class, 'destroy'])->name('tenant.test.delete');
});


//Exam
Route::prefix('exam')->group(function () {
    Route::get('/', [AdminExamController::class, 'index'])->name('tenant.exam.index');
    Route::get('/create', [AdminExamController::class, 'create'])->name('tenant.exam.create');
    Route::post('/store', [AdminExamController::class, 'store'])->name('tenant.exam.store');
    Route::get('/edit/{id}', [AdminExamController::class, 'edit'])->name('tenant.exam.edit');
    Route::post('/update/{id}', [AdminExamController::class, 'update'])->name('tenant.exam.update');
    Route::get('/delete/{id}', [AdminExamController::class, 'destroy'])->name('tenant.exam.delete');
});

//Billing Page
        Route::get('/admin/billing', [\App\Http\Controllers\Admin\BillingController::class, 'index'])
        ->name('tenant.billing');



// Admin management ends here


// ── TEACHER STUDENTS ──────────────────────────────
Route::get('/teacher/students', [TeacherStudentController::class, 'index'])
    ->name('tenant.teacher.students');

// ── TEACHER RESULTS ───────────────────────────────

// ✅ bulk GET must come BEFORE {student} to avoid route collision
Route::get('/teacher/results/bulk', [ResultController::class, 'bulk'])
    ->name('tenant.teacher.results.bulk');

Route::post('/teacher/results/bulk', [ResultController::class, 'bulkStore'])
    ->name('tenant.teacher.results.bulk.store');

// ✅ submit needs subject_id in URL
Route::post('/teacher/results/submit/{subject}', [ResultController::class, 'submit'])
    ->name('tenant.teacher.results.submit');

Route::get('/teacher/results', [ResultController::class, 'index'])
    ->name('tenant.teacher.results.index');

Route::get('/teacher/results/create', [ResultController::class, 'create'])
    ->name('tenant.teacher.results.create');

Route::post('/teacher/results', [ResultController::class, 'store'])
    ->name('tenant.teacher.results.store');

// ✅ {student} routes AFTER static routes
Route::get('/teacher/results/{student}/edit', [ResultController::class, 'edit'])
    ->name('tenant.teacher.results.edit');

Route::post('/teacher/results/{student}', [ResultController::class, 'update'])
    ->name('tenant.teacher.results.update');

    // Timetable
    Route::get('/timetable', [TeacherTimetableController::class, 'index'])
    ->name('teacher.timetable');

// teacher stops here
    
    

});



// STUDENT AUTH
// Route::prefix('{subdomain}/student')->group(function () {

//     Route::get('/login', [AuthController::class, 'showLogin'])->name('student.login');
//     Route::post('/login', [AuthController::class, 'login'])->name('student.login.post');

//     Route::middleware('student.auth')->group(function () {
//         Route::get('/dashboard', [DashboardController::class, 'index'])->name('student.dashboard');
//         Route::get('/logout', [AuthController::class, 'logout'])->name('student.logout');
//     });

// });

// STUDENT AUTH
Route::domain('{subdomain}.coredesk.local')->middleware('web', 'tenant.status')->group(function () {

    Route::prefix('student')->group(function () {

        Route::get('/login', [AuthController::class, 'showLogin'])->name('student.login');
        Route::post('/login', [AuthController::class, 'login'])->name('student.login.post');

        Route::middleware(\App\Http\Middleware\StudentAuth::class)->group(function () {
            //Dashboard
            Route::get('/dashboard', [StudentDashboardController::class, 'index'])->name('student.dashboard');
            //My Results
            Route::get('/results', [StudentResultController::class, 'index'])->name('student.results.index');
            // My Subject
            Route::get('/subjects', [StudentSubjectController::class, 'index'])->name('student.subjects');
            //My Teacher
            Route::get('/teachers', [StudentTeacherController::class, 'index'])->name('student.teachers');
            // My Profile
            Route::get('/profile', [ProfileController::class, 'index'])->name('student.profile');
            //Timetables
            Route::get('/timetable', [TimetableController::class, 'index'])->name('student.timetable');
            //test timetable
            Route::get('/tests', [TestController::class, 'index'])->name('student.tests');
            //exam timetable
            Route::get('/exams', [ExamController::class, 'index'])->name('student.exams');


            // Logout
            Route::get('/logout', [AuthController::class, 'logout'])->name('student.logout');
        });

    });

});

