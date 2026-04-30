@extends('layouts.admin')

@section('content')

@php 
    $subdomain = request()->route('subdomain'); 
    $teacher = auth()->user()->teacher;
    
    // Get dynamic counts
    $subjectsCount = $teacher ? $teacher->subjects()->count() : 0;
    $studentsCount = $teacher ? \App\Models\Student::where('tenant_id', auth()->user()->tenant_id)
        ->where('teacher_id', $teacher->id)->count() : 0;
    $classesCount = $teacher ? $teacher->subjects()->distinct('class_id')->count('class_id') : 0;
    
    // Placeholder for other stats (to be replaced with real data later)
    $assignmentsCount = 0;
    $resultsCount = 0;
    $attendanceRate = 0;
@endphp

<div class="w-full px-6 py-6 mx-auto">

    {{-- PAGE HEADER --}}
    <div class="flex flex-wrap items-center justify-between mb-6 -mx-3">
        <div class="px-3">
            <h3 class="text-2xl font-bold text-slate-700 mb-1">Teacher Portal</h3>
            <p class="text-sm text-slate-400">
                <i class="fa fa-home mr-1"></i> Dashboard
                <span class="mx-1 text-slate-300">/</span>
                <span class="text-slate-600"><i class="fa fa-chalkboard-user mr-1 fa-flip"></i>My Workspace</span>
            </p>
        </div>
        <div class="px-3 flex gap-3 mt-3 md:mt-0">
            <a href="{{ route('teacher.attendance.index', $subdomain) }}" class="px-4 py-2 text-sm font-semibold text-white rounded-lg bg-gradient-to-tl from-blue-600 to-cyan-400 shadow-soft-md hover:shadow-soft-xl hover:scale-105 transition-all">
                <i class="fa fa-calendar-check mr-1 text-black"></i> Attendance
            </a>
            <a href="{{ route('tenant.teacher.results.index', $subdomain) }}" class="px-4 py-2 text-sm font-semibold text-primary rounded-lg bg-gradient-to-tl from-green-600 to-emerald-400 shadow-soft-md hover:shadow-soft-xl hover:scale-105 transition-all">
                <i class="fa fa-star mr-1 text-white"></i> Results
            </a>
            <a href="#" class="px-4 py-2 text-sm font-semibold text-black rounded-lg bg-gradient-to-tl from-purple-600 to-pink-500 shadow-soft-md hover:shadow-soft-xl hover:scale-105 transition-all">
                <i class="fa fa-tasks mr-1"></i> Assignments
            </a>
        </div>
    </div>

    {{-- STAT CARDS ROW 1 — 4 CARDS --}}
    <div class="flex flex-wrap -mx-3 mb-6">
        
        <!-- card1 - My Subjects -->
        <div class="w-full max-w-full px-3 mb-6 sm:w-1/2 sm:flex-none xl:mb-0 xl:w-1/4">
            <div class="relative flex flex-col min-w-0 break-words bg-white shadow-soft-xl rounded-2xl bg-clip-border">
                <div class="flex-auto p-4">
                    <div class="flex flex-row -mx-3">
                        <div class="flex-none w-2/3 max-w-full px-3">
                            <div>
                                <p class="mb-0 font-sans text-sm font-semibold leading-normal">My Subjects</p>
                                <h5 class="mb-0 font-bold">
                                    {{ $subjectsCount }}
                                    <span class="text-sm leading-normal font-weight-bolder text-blue-500">assigned</span>
                                </h5>
                            </div>
                        </div>
                        <div class="px-3 text-right basis-1/3">
                            <div class="inline-block w-12 h-12 text-center rounded-lg bg-gradient-to-tl from-blue-500 to-cyan-400">
                                <i class="fa fa-book-open text-lg relative top-3.5 text-info"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- card2 - My Students -->
        <div class="w-full max-w-full px-3 mb-6 sm:w-1/2 sm:flex-none xl:mb-0 xl:w-1/4">
            <div class="relative flex flex-col min-w-0 break-words bg-white shadow-soft-xl rounded-2xl bg-clip-border">
                <div class="flex-auto p-4">
                    <div class="flex flex-row -mx-3">
                        <div class="flex-none w-2/3 max-w-full px-3">
                            <div>
                                <p class="mb-0 font-sans text-sm font-semibold leading-normal">My Students</p>
                                <h5 class="mb-0 font-bold">
                                    {{ $studentsCount }}
                                    <span class="text-sm leading-normal font-weight-bolder text-green-500">total</span>
                                </h5>
                            </div>
                        </div>
                        <div class="px-3 text-right basis-1/3">
                            <div class="inline-block w-12 h-12 text-center rounded-lg bg-gradient-to-tl from-green-500 to-emerald-400">
                                <i class="fa fa-user-graduate text-lg relative top-3.5 text-primary"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- card3 - My Classes -->
        <div class="w-full max-w-full px-3 mb-6 sm:w-1/2 sm:flex-none xl:mb-0 xl:w-1/4">
            <div class="relative flex flex-col min-w-0 break-words bg-white shadow-soft-xl rounded-2xl bg-clip-border">
                <div class="flex-auto p-4">
                    <div class="flex flex-row -mx-3">
                        <div class="flex-none w-2/3 max-w-full px-3">
                            <div>
                                <p class="mb-0 font-sans text-sm font-semibold leading-normal">My Classes</p>
                                <h5 class="mb-0 font-bold">
                                    {{ $classesCount }}
                                    <span class="text-sm leading-normal font-weight-bolder text-purple-500">classes</span>
                                </h5>
                            </div>
                        </div>
                        <div class="px-3 text-right basis-1/3">
                            <div class="inline-block w-12 h-12 text-center rounded-lg bg-gradient-to-tl from-purple-600 to-pink-500">
                                <i class="fa fa-chalkboard text-lg relative top-3.5 text-black"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- card4 - Assignments -->
        <div class="w-full max-w-full px-3 sm:w-1/2 sm:flex-none xl:w-1/4">
            <div class="relative flex flex-col min-w-0 break-words bg-white shadow-soft-xl rounded-2xl bg-clip-border">
                <div class="flex-auto p-4">
                    <div class="flex flex-row -mx-3">
                        <div class="flex-none w-2/3 max-w-full px-3">
                            <div>
                                <p class="mb-0 font-sans text-sm font-semibold leading-normal">Assignments</p>
                                <h5 class="mb-0 font-bold">
                                    {{ $assignmentsCount }}
                                    <span class="text-sm leading-normal font-weight-bolder text-orange-500">pending</span>
                                </h5>
                            </div>
                        </div>
                        <div class="px-3 text-right basis-1/3">
                            <div class="inline-block w-12 h-12 text-center rounded-lg bg-gradient-to-tl from-orange-500 to-yellow-400">
                                <i class="fa fa-tasks text-lg relative top-3.5 text-black"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    {{-- STAT CARDS ROW 2 — 4 CARDS --}}
    <div class="flex flex-wrap -mx-3 mb-6">
        
        <!-- card5 - Results Submitted -->
        <div class="w-full max-w-full px-3 mb-6 sm:w-1/2 sm:flex-none xl:mb-0 xl:w-1/4">
            <div class="relative flex flex-col min-w-0 break-words bg-white shadow-soft-xl rounded-2xl bg-clip-border">
                <div class="flex-auto p-4">
                    <div class="flex flex-row -mx-3">
                        <div class="flex-none w-2/3 max-w-full px-3">
                            <div>
                                <p class="mb-0 font-sans text-sm font-semibold leading-normal">Results Submitted</p>
                                <h5 class="mb-0 font-bold">
                                    {{ $resultsCount }}
                                    <span class="text-sm leading-normal font-weight-bolder text-teal-500">this term</span>
                                </h5>
                            </div>
                        </div>
                        <div class="px-3 text-right basis-1/3">
                            <div class="inline-block w-12 h-12 text-center rounded-lg bg-gradient-to-tl from-teal-500 to-green-400">
                                <i class="fa fa-chart-bar text-lg relative top-3.5 text-black"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- card6 - Attendance Rate -->
        <div class="w-full max-w-full px-3 mb-6 sm:w-1/2 sm:flex-none xl:mb-0 xl:w-1/4">
            <div class="relative flex flex-col min-w-0 break-words bg-white shadow-soft-xl rounded-2xl bg-clip-border">
                <div class="flex-auto p-4">
                    <div class="flex flex-row -mx-3">
                        <div class="flex-none w-2/3 max-w-full px-3">
                            <div>
                                <p class="mb-0 font-sans text-sm font-semibold leading-normal">Attendance Rate</p>
                                <h5 class="mb-0 font-bold">
                                    {{ $attendanceRate }}%
                                    <span class="text-sm leading-normal font-weight-bolder text-indigo-500">avg</span>
                                </h5>
                            </div>
                        </div>
                        <div class="px-3 text-right basis-1/3">
                            <div class="inline-block w-12 h-12 text-center rounded-lg bg-gradient-to-tl from-indigo-500 to-blue-400">
                                <i class="fa fa-calendar-check text-lg relative top-3.5 text-black"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- card7 - Upcoming Tests -->
        <div class="w-full max-w-full px-3 mb-6 sm:w-1/2 sm:flex-none xl:mb-0 xl:w-1/4">
            <div class="relative flex flex-col min-w-0 break-words bg-white shadow-soft-xl rounded-2xl bg-clip-border">
                <div class="flex-auto p-4">
                    <div class="flex flex-row -mx-3">
                        <div class="flex-none w-2/3 max-w-full px-3">
                            <div>
                                <p class="mb-0 font-sans text-sm font-semibold leading-normal">Upcoming Tests</p>
                                <h5 class="mb-0 font-bold">
                                    0
                                    <span class="text-sm leading-normal text-red-600 font-weight-bolder">this week</span>
                                </h5>
                            </div>
                        </div>
                        <div class="px-3 text-right basis-1/3">
                            <div class="inline-block w-12 h-12 text-center rounded-lg bg-gradient-to-tl from-red-500 to-rose-400">
                                <i class="fa fa-pen-alt text-lg relative top-3.5 text-black"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- card8 - Notifications -->
        <div class="w-full max-w-full px-3 sm:w-1/2 sm:flex-none xl:w-1/4">
            <div class="relative flex flex-col min-w-0 break-words bg-white shadow-soft-xl rounded-2xl bg-clip-border">
                <div class="flex-auto p-4">
                    <div class="flex flex-row -mx-3">
                        <div class="flex-none w-2/3 max-w-full px-3">
                            <div>
                                <p class="mb-0 font-sans text-sm font-semibold leading-normal">Notifications</p>
                                <h5 class="mb-0 font-bold">
                                    0
                                    <span class="text-sm leading-normal font-weight-bolder text-slate-500">unread</span>
                                </h5>
                            </div>
                        </div>
                        <div class="px-3 text-right basis-1/3">
                            <div class="inline-block w-12 h-12 text-center rounded-lg bg-gradient-to-tl from-slate-600 to-slate-400">
                                <i class="fa fa-bell text-lg relative top-3.5 text-black"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    {{-- CORE MODULES SECTION --}}
<div class="mb-6 col-12">
    
    <div class="flex items-center justify-between mb-4">
        <h6 class="text-xs font-bold uppercase text-slate-400 tracking-widest">
            Quick Access Modules
        </h6>
        <div class="h-px flex-1 bg-gradient-to-r from-transparent via-slate-200 to-transparent ml-4"></div>
    </div>

    <div class="row">

        {{-- LEFT COLUMN (4 ITEMS) --}}
        <div class="col-md-6">

            {{-- Item 1 --}}
            <div class="mb-4 bg-gradient-to-br from-blue-50 to-white rounded-2xl p-5 border border-blue-100 hover:shadow-lg transition-all duration-300">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 rounded-xl bg-gradient-to-tl from-blue-500 to-cyan-400 flex items-center justify-center">
                            <i class="fa fa-book-open text-primary"></i>
                        </div>
                        <div>
                            <h6 class="font-bold text-slate-700">My Subjects</h6>
                            <p class="text-xs text-slate-400">View subjects assigned to you</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Item 2 --}}
            <div class="mb-4 bg-gradient-to-br from-purple-50 to-white rounded-2xl p-5 border border-purple-100 hover:shadow-lg">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 rounded-xl bg-gradient-to-tl from-purple-600 to-pink-500 flex items-center justify-center">
                        <i class="fa fa-chalkboard text-primary"></i>
                    </div>
                    <div>
                        <h6 class="font-bold text-slate-700">My Classes</h6>
                        <p class="text-xs text-slate-400">View your assigned classes</p>
                    </div>
                </div>
            </div>

            {{-- Item 3 --}}
            <div class="mb-4 bg-gradient-to-br from-red-50 to-white rounded-2xl p-5 border border-red-100 hover:shadow-lg">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 rounded-xl bg-gradient-to-tl from-red-500 to-rose-400 flex items-center justify-center">
                        <i class="fa fa-star text-primary"></i>
                    </div>
                    <div>
                        <h6 class="font-bold text-slate-700">Results</h6>
                        <p class="text-xs text-slate-400">Upload and manage results</p>
                    </div>
                </div>
            </div>

            {{-- Item 4 --}}
            <div class="mb-4 bg-gradient-to-br from-indigo-50 to-white rounded-2xl p-5 border border-indigo-100 hover:shadow-lg">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 rounded-xl bg-gradient-to-tl from-indigo-500 to-blue-400 flex items-center justify-center">
                        <i class="fa fa-clock text-primary"></i>
                    </div>
                    <div>
                        <h6 class="font-bold text-slate-700">Timetable</h6>
                        <p class="text-xs text-slate-400">View your schedule</p>
                    </div>
                </div>
            </div>

        </div>

        {{-- RIGHT COLUMN (4 ITEMS) --}}
        <div class="col-md-6">

            {{-- Item 5 --}}
            <div class="mb-4 bg-gradient-to-br from-green-50 to-white rounded-2xl p-5 border border-green-100 hover:shadow-lg">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 rounded-xl bg-gradient-to-tl from-green-500 to-emerald-400 flex items-center justify-center">
                        <i class="fa fa-user-graduate text-black"></i>
                    </div>
                    <div>
                        <h6 class="font-bold text-slate-700">My Students</h6>
                        <p class="text-xs text-slate-400">Manage your students</p>
                    </div>
                </div>
            </div>

            {{-- Item 6 --}}
            <div class="mb-4 bg-gradient-to-br from-orange-50 to-white rounded-2xl p-5 border border-orange-100 hover:shadow-lg">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 rounded-xl bg-gradient-to-tl from-orange-500 to-yellow-400 flex items-center justify-center">
                        <i class="fa fa-calendar-check text-black"></i>
                    </div>
                    <div>
                        <h6 class="font-bold text-slate-700">Attendance</h6>
                        <p class="text-xs text-slate-400">Take and manage attendance</p>
                    </div>
                </div>
            </div>

            {{-- Item 7 --}}
            <div class="mb-4 bg-gradient-to-br from-teal-50 to-white rounded-2xl p-5 border border-teal-100 hover:shadow-lg">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 rounded-xl bg-gradient-to-tl from-teal-500 to-green-400 flex items-center justify-center">
                        <i class="fa fa-tasks text-primary"></i>
                    </div>
                    <div>
                        <h6 class="font-bold text-slate-700">Assignments</h6>
                        <p class="text-xs text-slate-400">Create and grade assignments</p>
                    </div>
                </div>
            </div>

            {{-- Item 8 --}}
            <div class="mb-4 bg-gradient-to-br from-slate-50 to-white rounded-2xl p-5 border border-slate-200 hover:shadow-lg">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 rounded-xl bg-gradient-to-tl from-slate-600 to-slate-400 flex items-center justify-center">
                        <i class="fa fa-chart-line text-primary"></i>
                    </div>
                    <div>
                        <h6 class="font-bold text-slate-700">Analytics</h6>
                        <p class="text-xs text-slate-400">View performance insights</p>
                    </div>
                </div>
            </div>

        </div>

    </div>
</div>

    {{-- COMING SOON SECTION --}}
    <div>
        <h6 class="text-xs font-bold uppercase text-slate-400 tracking-widest mb-3 pl-1">
            Coming Soon
        </h6>
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-3">
            
            <div class="relative bg-gray-50 rounded-xl p-3 opacity-60 border border-dashed border-gray-200">
                <span class="absolute top-2 right-2 text-xs bg-gray-200 text-gray-500 px-2 py-0.5 rounded-full">Soon</span>
                <div class="w-10 h-10 rounded-xl bg-gray-200 flex items-center justify-center mb-2 mx-auto">
                    <i class="fa fa-laptop text-gray-400 text-sm"></i>
                </div>
                <span class="text-xs font-semibold text-slate-500 block text-center">CBT Exams</span>
            </div>

            <div class="relative bg-gray-50 rounded-xl p-3 opacity-60 border border-dashed border-gray-200">
                <span class="absolute top-2 right-2 text-xs bg-gray-200 text-gray-500 px-2 py-0.5 rounded-full">Soon</span>
                <div class="w-10 h-10 rounded-xl bg-gray-200 flex items-center justify-center mb-2 mx-auto">
                    <i class="fa fa-flask text-gray-400 text-sm"></i>
                </div>
                <span class="text-xs font-semibold text-slate-500 block text-center">Test Builder</span>
            </div>

            <div class="relative bg-gray-50 rounded-xl p-3 opacity-60 border border-dashed border-gray-200">
                <span class="absolute top-2 right-2 text-xs bg-gray-200 text-gray-500 px-2 py-0.5 rounded-full">Soon</span>
                <div class="w-10 h-10 rounded-xl bg-gray-200 flex items-center justify-center mb-2 mx-auto">
                    <i class="fa fa-folder-open text-gray-400 text-sm"></i>
                </div>
                <span class="text-xs font-semibold text-slate-500 block text-center">Handouts</span>
            </div>

            <div class="relative bg-gray-50 rounded-xl p-3 opacity-60 border border-dashed border-gray-200">
                <span class="absolute top-2 right-2 text-xs bg-gray-200 text-gray-500 px-2 py-0.5 rounded-full">Soon</span>
                <div class="w-10 h-10 rounded-xl bg-gray-200 flex items-center justify-center mb-2 mx-auto">
                    <i class="fa fa-chart-pie text-gray-400 text-sm"></i>
                </div>
                <span class="text-xs font-semibold text-slate-500 block text-center">Analytics</span>
            </div>

            <div class="relative bg-gray-50 rounded-xl p-3 opacity-60 border border-dashed border-gray-200">
                <span class="absolute top-2 right-2 text-xs bg-gray-200 text-gray-500 px-2 py-0.5 rounded-full">Soon</span>
                <div class="w-10 h-10 rounded-xl bg-gray-200 flex items-center justify-center mb-2 mx-auto">
                    <i class="fa fa-comments text-gray-400 text-sm"></i>
                </div>
                <span class="text-xs font-semibold text-slate-500 block text-center">Messaging</span>
            </div>

            <div class="relative bg-gray-50 rounded-xl p-3 opacity-60 border border-dashed border-gray-200">
                <span class="absolute top-2 right-2 text-xs bg-gray-200 text-gray-500 px-2 py-0.5 rounded-full">Soon</span>
                <div class="w-10 h-10 rounded-xl bg-gray-200 flex items-center justify-center mb-2 mx-auto">
                    <i class="fa fa-calendar-alt text-gray-400 text-sm"></i>
                </div>
                <span class="text-xs font-semibold text-slate-500 block text-center">Lesson Plan</span>
            </div>

        </div>
    </div>

</div>

@endsection