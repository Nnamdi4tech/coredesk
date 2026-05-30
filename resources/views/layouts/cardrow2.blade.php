<!-- cards row 2 -->
<div class="flex flex-wrap mt-6 -mx-3">
    <div class="w-full px-3 mb-6 lg:mb-0 lg:w-7/12 lg:flex-none">
        <div class="relative flex flex-col min-w-0 break-words bg-white shadow-soft-xl rounded-2xl bg-clip-border">
            <div class="flex-auto p-4">
                <div class="flex flex-wrap -mx-3">
                    <div class="max-w-full px-3 lg:w-1/2 lg:flex-none">
                        <div class="flex flex-col h-full">
                            <p class="pt-2 mb-1 font-semibold text-purple-700">School Management</p>
                            <h5 class="font-bold">Complete Control at Your Fingertips</h5>
                            <p class="mb-12">
                                Manage students, teachers, classes, results, and finances all from one powerful dashboard. 
                                Streamline your school operations and focus on what matters most — education.
                            </p>
                            <a class="mt-auto mb-0 text-sm font-semibold leading-normal group text-purple-700" 
                               href="{{ route('tenant.students.index', $subdomain) }}">
                                Manage Students
                                <i class="fas fa-arrow-right ease-bounce text-sm group-hover:translate-x-1.25 ml-1 leading-normal transition-all duration-200"></i>
                            </a>
                        </div>
                    </div>
                    <div class="max-w-full px-3 mt-12 ml-auto text-center lg:mt-0 lg:w-5/12 lg:flex-none">
                        <div class="h-full bg-gradient-to-tl from-purple-700 to-pink-500 rounded-xl">
                            <img src="{{ asset('dashboard/build/assets/img/shapes/waves-white.svg') }}" 
                                 class="absolute top-0 hidden w-1/2 h-full lg:block" alt="waves" />
                            <div class="relative flex items-center justify-center h-full">
                                <img class="relative z-20 w-full pt-6" 
                                     src="{{ asset('dashboard/build/assets/img/illustrations/rocket-white.png') }}"  
                                     alt="School Management" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="w-full max-w-full px-3 lg:w-5/12 lg:flex-none">
        <div class="border-black/12.5 shadow-soft-xl relative flex h-full min-w-0 flex-col break-words rounded-2xl border-0 border-solid bg-white bg-clip-border p-4">
            <div class="relative h-full overflow-hidden bg-cover rounded-xl" 
                 style="background-image: url('{{ asset('dashboard/build/assets/img/ivancik.jpg') }}')"> 
                <span class="absolute top-0 left-0 w-full h-full bg-center bg-cover bg-gradient-to-tl from-purple-900 to-purple-800 opacity-90"></span>
                <div class="relative z-10 flex flex-col flex-auto h-full p-4">
                    <h5 class="pt-2 mb-3 font-bold text-white">
                        Track Academic Performance
                    </h5>
                    <p class="text-white text-sm leading-relaxed">
                        Record and manage student results, generate report cards, 
                        track class performance, and identify areas for improvement — 
                        all in real-time with detailed analytics.
                    </p>
                    <div class="mt-4 flex gap-3">
                        <a class="text-xs font-semibold text-white group flex items-center" 
                           href="{{ route('tenant.admin.results.index', $subdomain ?? '') }}">
                            View Results
                            <i class="fas fa-arrow-right text-xs group-hover:translate-x-1 ml-1 transition-all duration-200"></i>
                        </a>
                        <a class="text-xs font-semibold text-white group flex items-center" 
                           href="{{ route('tenant.timetable.index', $subdomain ?? '') }}">
                            View Timetable
                            <i class="fas fa-arrow-right text-xs group-hover:translate-x-1 ml-1 transition-all duration-200"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- cards row 3 - Additional Features -->
<!-- <div class="flex flex-wrap mt-6 -mx-3">
    <div class="w-full max-w-full px-3 lg:w-4/12 lg:flex-none">
        <div class="relative flex flex-col min-w-0 break-words bg-white shadow-soft-xl rounded-2xl bg-clip-border">
            <div class="flex-auto p-4 text-center">
                <div class="w-16 h-16 mx-auto mb-4 rounded-lg bg-gradient-to-tl from-purple-700 to-pink-500 flex items-center justify-center">
                    <i class="fa fa-users text-white text-2xl"></i>
                </div>
                <h6 class="font-bold">Student Management</h6>
                <p class="text-sm text-slate-500 mb-3">
                    Enroll students, track attendance, manage profiles, and monitor academic progress effortlessly.
                </p>
                <a href="{{ route('tenant.students.index', $subdomain ?? '') }}" 
                   class="text-sm font-semibold text-purple-700 hover:underline">
                    Manage Students →
                </a>
            </div>
        </div>
    </div>
    
    <div class="w-full max-w-full px-3 mt-4 lg:mt-0 lg:w-4/12 lg:flex-none">
        <div class="relative flex flex-col min-w-0 break-words bg-white shadow-soft-xl rounded-2xl bg-clip-border">
            <div class="flex-auto p-4 text-center">
                <div class="w-16 h-16 mx-auto mb-4 rounded-lg bg-gradient-to-tl from-purple-700 to-pink-500 flex items-center justify-center">
                    <i class="fa fa-chalkboard-user text-white text-2xl"></i>
                </div>
                <h6 class="font-bold">Teacher Management</h6>
                <p class="text-sm text-slate-500 mb-3">
                    Manage teacher profiles, assign subjects, track performance, and streamline communication.
                </p>
                <a href="{{ route('tenant.teachers.index', $subdomain ?? '') }}" 
                   class="text-sm font-semibold text-purple-700 hover:underline">
                    Manage Teachers →
                </a>
            </div>
        </div>
    </div>
    
    <div class="w-full max-w-full px-3 mt-4 lg:mt-0 lg:w-4/12 lg:flex-none">
        <div class="relative flex flex-col min-w-0 break-words bg-white shadow-soft-xl rounded-2xl bg-clip-border">
            <div class="flex-auto p-4 text-center">
                <div class="w-16 h-16 mx-auto mb-4 rounded-lg bg-gradient-to-tl from-purple-700 to-pink-500 flex items-center justify-center">
                    <i class="fa fa-book-open text-white text-2xl"></i>
                </div>
                <h6 class="font-bold">Subjects & Classes</h6>
                <p class="text-sm text-slate-500 mb-3">
                    Organize subjects, create classes, assign teachers, and manage curriculum structure.
                </p>
                <a href="{{ route('tenant.subjects.index', $subdomain ?? '') }}" 
                   class="text-sm font-semibold text-purple-700 hover:underline">
                    Manage Subjects →
                </a>
            </div>
        </div>
    </div>
</div> -->

<!-- cards row 4 - More Features -->
<!-- <div class="flex flex-wrap mt-6 -mx-3">
    <div class="w-full max-w-full px-3 lg:w-4/12 lg:flex-none">
        <div class="relative flex flex-col min-w-0 break-words bg-white shadow-soft-xl rounded-2xl bg-clip-border">
            <div class="flex-auto p-4 text-center">
                <div class="w-16 h-16 mx-auto mb-4 rounded-lg bg-gradient-to-tl from-purple-700 to-pink-500 flex items-center justify-center">
                    <i class="fa fa-calendar-alt text-white text-2xl"></i>
                </div>
                <h6 class="font-bold">Class Timetable</h6>
                <p class="text-sm text-slate-500 mb-3">
                    Create and manage class schedules, avoid conflicts, and organize daily activities efficiently.
                </p>
                <a href="{{ route('tenant.timetable.index', $subdomain ?? '') }}" 
                   class="text-sm font-semibold text-purple-700 hover:underline">
                    View Timetable →
                </a>
            </div>
        </div>
    </div>
    
    <div class="w-full max-w-full px-3 mt-4 lg:mt-0 lg:w-4/12 lg:flex-none">
        <div class="relative flex flex-col min-w-0 break-words bg-white shadow-soft-xl rounded-2xl bg-clip-border">
            <div class="flex-auto p-4 text-center">
                <div class="w-16 h-16 mx-auto mb-4 rounded-lg bg-gradient-to-tl from-purple-700 to-pink-500 flex items-center justify-center">
                    <i class="fa fa-chart-line text-white text-2xl"></i>
                </div>
                <h6 class="font-bold">Results & Reports</h6>
                <p class="text-sm text-slate-500 mb-3">
                    Record student scores, generate report cards, and track academic performance trends.
                </p>
                <a href="{{ route('tenant.admin.results.index', $subdomain ?? '') }}" 
                   class="text-sm font-semibold text-purple-700 hover:underline">
                    View Results →
                </a>
            </div>
        </div>
    </div>
    
    <div class="w-full max-w-full px-3 mt-4 lg:mt-0 lg:w-4/12 lg:flex-none">
        <div class="relative flex flex-col min-w-0 break-words bg-white shadow-soft-xl rounded-2xl bg-clip-border">
            <div class="flex-auto p-4 text-center">
                <div class="w-16 h-16 mx-auto mb-4 rounded-lg bg-gradient-to-tl from-purple-700 to-pink-500 flex items-center justify-center">
                    <i class="fa fa-credit-card text-white text-2xl"></i>
                </div>
                <h6 class="font-bold">Billing & Payments</h6>
                <p class="text-sm text-slate-500 mb-3">
                    Manage school fees, track payments, and handle financial records in one place.
                </p>
                <a href="{{ route('tenant.billing', $subdomain ?? '') }}" 
                   class="text-sm font-semibold text-purple-700 hover:underline">
                    View Billing →
                </a>
            </div>
        </div>
    </div>
</div> -->


<!-- cards row 3 - Login Guide Header -->
<!-- <div class="flex flex-wrap mt-6 -mx-3">
    <div class="w-full max-w-full px-3">
        <div class="relative flex flex-col min-w-0 break-words bg-white shadow-soft-xl rounded-2xl bg-clip-border">
            <div class="flex-auto p-6 text-center">
                <div class="w-16 h-16 mx-auto mb-4 rounded-lg bg-gradient-to-tl from-purple-700 to-pink-500 flex items-center justify-center">
                    <i class="fa fa-key text-white text-2xl"></i>
                </div>
                <h5 class="font-bold text-2xl text-slate-700">How to Access Your Dashboard</h5>
                <p class="text-slate-500 mt-2 max-w-2xl mx-auto">
                    Each user role has a specific login URL. Use the guide below to access your correct dashboard.
                </p>
            </div>
        </div>
    </div>
</div> -->

<!-- cards row 4 - Login Cards (4 cards per row matching pattern) -->
<!-- <div class="flex flex-wrap mt-6 -mx-3">
    
    Card 1 - Super Admin / Admin 
    <div class="w-full max-w-full px-3 mb-6 lg:mb-0 lg:w-1/4">
        <div class="relative flex flex-col min-w-0 break-words bg-white shadow-soft-xl rounded-2xl bg-clip-border h-full hover:shadow-xl transition-all duration-300">
            <div class="flex-auto p-4 text-center">
                <div class="w-16 h-16 mx-auto mb-4 rounded-lg bg-gradient-to-tl from-blue-600 to-cyan-400 flex items-center justify-center">
                    <i class="fa fa-user-shield text-white text-2xl"></i>
                </div>
                <h6 class="font-bold text-slate-700 text-lg">Super Admin / Admin</h6>
                <div class="mt-3 p-3 bg-gray-50 rounded-xl">
                    <p class="text-xs text-slate-400 mb-1">Login URL:</p>
                    <code class="text-xs font-mono font-semibold text-blue-600 break-all">
                                        your-school.coredesk.local/login
                                    </code>
                </div>
                <div class="mt-3 text-left">
                    <p class="text-xs font-semibold text-slate-600 mb-2">Steps:</p>
                    <ul class="text-xs text-slate-500 space-y-1.5">
                        <li class="flex items-start gap-2">
                            <i class="fa fa-check-circle text-green-500 text-xs mt-0.5"></i>
                            <span>Go to your school's subdomain URL</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <i class="fa fa-check-circle text-green-500 text-xs mt-0.5"></i>
                            <span>Enter your registered email and password</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <i class="fa fa-check-circle text-green-500 text-xs mt-0.5"></i>
                            <span>Click "Sign In" to access dashboard</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

     Card 2 - Teacher -->
    <!-- <div class="w-full max-w-full px-3 mb-6 lg:mb-0 lg:w-1/4">
        <div class="relative flex flex-col min-w-0 break-words bg-white shadow-soft-xl rounded-2xl bg-clip-border h-full hover:shadow-xl transition-all duration-300">
            <div class="flex-auto p-4 text-center">
                <div class="w-16 h-16 mx-auto mb-4 rounded-lg bg-gradient-to-tl from-green-600 to-emerald-400 flex items-center justify-center">
                    <i class="fa fa-chalkboard-user text-white text-2xl"></i>
                </div>
                <h6 class="font-bold text-slate-700 text-lg">Teacher</h6>
                <div class="mt-3 p-3 bg-gray-50 rounded-xl">
                    <p class="text-xs text-slate-400 mb-1">Login URL:</p>
                    <code class="text-xs font-mono font-semibold text-green-600 break-all">
                                        your-school.coredesk.local/login
                                    </code>
                </div>
                <div class="mt-3 text-left">
                    <p class="text-xs font-semibold text-slate-600 mb-2">Steps:</p>
                    <ul class="text-xs text-slate-500 space-y-1.5">
                        <li class="flex items-start gap-2">
                            <i class="fa fa-check-circle text-green-500 text-xs mt-0.5"></i>
                            <span>Go to your school's subdomain URL</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <i class="fa fa-check-circle text-green-500 text-xs mt-0.5"></i>
                            <span>Enter your teacher email and password</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <i class="fa fa-check-circle text-green-500 text-xs mt-0.5"></i>
                            <span>Click "Sign In" to access dashboard</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div> -->

    <!-- Card 3 - Student -->
    <!-- <div class="w-full max-w-full px-3 mb-6 lg:mb-0 lg:w-1/4">
        <div class="relative flex flex-col min-w-0 break-words bg-white shadow-soft-xl rounded-2xl bg-clip-border h-full hover:shadow-xl transition-all duration-300">
            <div class="flex-auto p-4 text-center">
                <div class="w-16 h-16 mx-auto mb-4 rounded-lg bg-gradient-to-tl from-purple-700 to-pink-500 flex items-center justify-center">
                    <i class="fa fa-user-graduate text-white text-2xl"></i>
                </div>
                <h6 class="font-bold text-slate-700 text-lg">Student</h6>
                <div class="mt-3 p-3 bg-gray-50 rounded-xl">
                    <p class="text-xs text-slate-400 mb-1">Login URL:</p>
                    <code class="text-xs font-mono font-semibold text-orange-600 break-all">
                                        your-school.coredesk.local/student/login
                                    </code>
                </div>
                <div class="mt-3 text-left">
                    <p class="text-xs font-semibold text-slate-600 mb-2">Steps:</p>
                    <ul class="text-xs text-slate-500 space-y-1.5">
                        <li class="flex items-start gap-2">
                            <i class="fa fa-check-circle text-green-500 text-xs mt-0.5"></i>
                            <span>Go to your school's subdomain URL</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <i class="fa fa-check-circle text-green-500 text-xs mt-0.5"></i>
                            <span>Add <strong class="text-orange-600">/student/login</strong> to URL</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <i class="fa fa-check-circle text-green-500 text-xs mt-0.5"></i>
                            <span>Enter your Student ID and password</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <i class="fa fa-check-circle text-green-500 text-xs mt-0.5"></i>
                            <span>Click "Sign In" to access portal</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div> -->

    <!-- Card 4 - Accountant -->
    <!-- <div class="w-full max-w-full px-3 lg:w-1/4">
        <div class="relative flex flex-col min-w-0 break-words bg-white shadow-soft-xl rounded-2xl bg-clip-border h-full hover:shadow-xl transition-all duration-300">
            <div class="flex-auto p-4 text-center">
                <div class="w-16 h-16 mx-auto mb-4 rounded-lg bg-gradient-to-tl from-purple-700 to-pink-500 flex items-center justify-center">
                    <i class="fa fa-calculator text-white text-2xl"></i>
                </div>
                
                <h6 class="font-bold text-slate-700 text-lg">Accountant / Bursar</h6>
                <div class="mt-3 p-3 bg-gray-50 rounded-xl">
                    <p class="text-xs text-slate-400 mb-1">Login URL:</p>
                    <code class="text-xs font-mono font-semibold text-purple-600 break-all">
                                        your-school.coredesk.local/login
                                    </code>
                </div>
                <div class="mt-3 text-left">
                    <p class="text-xs font-semibold text-slate-600 mb-2">Steps:</p>
                    <ul class="text-xs text-slate-500 space-y-1.5">
                        <li class="flex items-start gap-2">
                            <i class="fa fa-check-circle text-green-500 text-xs mt-0.5"></i>
                            <span>Go to your school's subdomain URL</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <i class="fa fa-check-circle text-green-500 text-xs mt-0.5"></i>
                            <span>Enter your accountant email and password</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <i class="fa fa-check-circle text-green-500 text-xs mt-0.5"></i>
                            <span>Click "Sign In" to access finance dashboard</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

</div> -->

<!-- cards row 5 - Important Note (matching pattern) -->
<div class="flex flex-wrap mt-6 -mx-3">
    <div class="w-full max-w-full px-3">
        <div class="relative flex flex-col min-w-0 break-words bg-amber-50 border border-amber-200 rounded-2xl bg-clip-border">
            <div class="flex-auto p-4 text-center">
                <div class="flex items-center justify-center gap-3">
                    <div class="w-10 h-10 rounded-lg bg-amber-500 flex items-center justify-center flex-shrink-0">
                        <i class="fa fa-info-circle text-white text-sm"></i>
                    </div>
                    <div>
                        <h6 class="font-bold text-amber-800 text-sm">Important Note</h6>
                        <p class="text-xs text-amber-700">
                            Each school has its own unique subdomain (e.g., <strong>your-school.coredesk.local</strong>). 
                            Make sure you're logging in through your school's specific subdomain URL. 
                            If you don't know your school's subdomain, contact your school administrator.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>