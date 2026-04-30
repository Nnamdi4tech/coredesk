@extends('layouts.admin')

@section('content')

@php $subdomain = request()->route('subdomain'); @endphp

<div class="w-full px-6 py-6 mx-auto">
    
    {{-- PAGE HEADER --}}
    <div class="flex flex-wrap items-center justify-between mb-6 -mx-3">
        <div class="px-3">
            <h3 class="text-2xl font-bold text-slate-700 mb-1">Student Dashboard</h3>
            <p class="text-sm text-slate-400">
                <i class="fa fa-home mr-1"></i> Dashboard
                <span class="mx-1 text-slate-300">/</span>
                <span class="text-slate-600">Student Portal</span>
            </p>
        </div>
        <div class="px-3 mt-3 md:mt-0">
            <a href="{{ route('student.logout', $subdomain) }}" 
               onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
               class="px-4 py-2 text-sm border border-gray-300 rounded-lg text-red-600 hover:bg-red-50 hover:border-red-300 transition-all">
                <i class="fa fa-sign-out-alt mr-1"></i> Logout
            </a>
            <form id="logout-form" method="POST" action="{{ route('student.logout', $subdomain) }}" style="display: none;">
                @csrf
            </form>
        </div>
    </div>

    {{-- Welcome Card --}}
    <div class="bg-gradient-to-r from-purple-700 to-pink-500 rounded-2xl shadow-soft-xl overflow-hidden mb-6">
        <div class="px-6 py-8">
            <div class="flex items-center gap-4">
                <div class="w-16 h-16 rounded-2xl bg-white/20 backdrop-blur-sm flex items-center justify-center">
                    <i class="fa fa-user-graduate text-white text-3xl"></i>
                </div>
                <div>
                    <h2 class="text-2xl font-bold text-white mb-1">Welcome back, {{ $student->name }}!</h2>
                    <p class="text-blue-100 text-sm text-white">We hope you're having a great day</p>
                </div>
            </div>
        </div>
    </div>

    {{-- Student Information Cards --}}
    <div class="flex flex-wrap -mx-3">
        
        {{-- Student ID Card --}}
        <div class="w-full max-w-full px-3 mb-6 sm:w-1/2 sm:flex-none xl:mb-0 xl:w-1/3">
            <div class="relative flex flex-col min-w-0 break-words bg-white shadow-soft-xl rounded-2xl bg-clip-border">
                <div class="flex-auto p-5">
                    <div class="flex flex-row -mx-3">
                        <div class="flex-none w-2/3 max-w-full px-3">
                            <div>
                                <p class="mb-0 font-sans text-sm font-semibold leading-normal text-slate-500">
                                    <i class="fa fa-id-card mr-1 text-slate-400"></i> Student ID
                                </p>
                                <h5 class="mb-0 font-bold text-slate-700 text-lg mt-1">
                                    {{ $student->student_id }}
                                </h5>
                            </div>
                        </div>
                        <div class="px-3 text-right basis-1/3">
                            <div class="inline-block w-12 h-12 text-center rounded-lg bg-gradient-to-tl from-blue-500 to-cyan-400">
                                <i class="fa fa-qrcode text-lg relative top-3.5 text-black"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Class Card --}}
        <div class="w-full max-w-full px-3 mb-6 sm:w-1/2 sm:flex-none xl:mb-0 xl:w-1/3">
            <div class="relative flex flex-col min-w-0 break-words bg-white shadow-soft-xl rounded-2xl bg-clip-border">
                <div class="flex-auto p-5">
                    <div class="flex flex-row -mx-3">
                        <div class="flex-none w-2/3 max-w-full px-3">
                            <div>
                                <p class="mb-0 font-sans text-sm font-semibold leading-normal text-slate-500">
                                    <i class="fa fa-chalkboard mr-1 text-slate-400"></i> Class
                                </p>
                                <h5 class="mb-0 font-bold text-slate-700 text-lg mt-1">
                                    {{ $student->schoolClass->name ?? 'N/A' }}
                                </h5>
                            </div>
                        </div>
                        <div class="px-3 text-right basis-1/3">
                            <div class="inline-block w-12 h-12 text-center rounded-lg bg-gradient-to-tl from-purple-500 to-pink-400">
                                <i class="fa fa-users text-lg relative top-3.5 text-black"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Teacher Card --}}
        <div class="w-full max-w-full px-3 mb-6 sm:w-1/2 sm:flex-none xl:mb-0 xl:w-1/3">
            <div class="relative flex flex-col min-w-0 break-words bg-white shadow-soft-xl rounded-2xl bg-clip-border">
                <div class="flex-auto p-5">
                    <div class="flex flex-row -mx-3">
                        <div class="flex-none w-2/3 max-w-full px-3">
                            <div>
                                <p class="mb-0 font-sans text-sm font-semibold leading-normal text-slate-500">
                                    <i class="fa fa-chalkboard-user mr-1 text-slate-400"></i> Class Teacher
                                </p>
                                <h5 class="mb-0 font-bold text-slate-700 text-lg mt-1">
                                    {{ $student->teacher->name ?? 'N/A' }}
                                </h5>
                            </div>
                        </div>
                        <div class="px-3 text-right basis-1/3">
                            <div class="inline-block w-12 h-12 text-center rounded-lg bg-gradient-to-tl from-green-500 to-emerald-400">
                                <i class="fa fa-user-tie text-lg relative top-3.5 text-black"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    {{-- Quick Actions Card --}}
    <div class="bg-white shadow-soft-xl rounded-2xl overflow-hidden mt-5">
        <div class="flex items-center gap-3 px-6 py-4 border-b border-gray-100">
            <div class="w-8 h-8 rounded-lg bg-gradient-to-tl from-amber-500 to-orange-400 flex items-center justify-center shadow-soft-md">
                <i class="fa fa-bolt text-black text-xs"></i>
            </div>
            <div>
                <h6 class="font-bold text-slate-700 mb-0">Quick Actions</h6>
                <p class="text-xs text-slate-400 mt-0.5">View your academic information</p>
            </div>
        </div>
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <a href="{{ route('student.results.index', request()->route('subdomain')) }}" class="flex items-center gap-3 p-4 bg-gray-50 rounded-xl hover:bg-gray-100 transition-all group">
                    <div class="w-10 h-10 rounded-lg bg-gradient-to-tl from-blue-500 to-cyan-400 flex items-center justify-center group-hover:scale-110 transition-all">
                        <i class="fa fa-chart-line text-black text-sm"></i>
                    </div>
                    <div>
                        <p class="text-sm font-semibold text-slate-700">View Results</p>
                        <p class="text-xs text-slate-400">Check your academic performance</p>
                    </div>
                    <i class="fa fa-chevron-right ml-auto text-slate-300 group-hover:text-slate-500 transition-all"></i>
                </a>
                <a href="{{ route('student.timetable', request()->route('subdomain')) }}" class="flex items-center gap-3 p-4 bg-gray-50 rounded-xl hover:bg-gray-100 transition-all group">
                    <div class="w-10 h-10 rounded-lg bg-gradient-to-tl from-purple-500 to-pink-400 flex items-center justify-center group-hover:scale-110 transition-all">
                        <i class="fa fa-calendar-alt text-black text-sm"></i>
                    </div>
                    <div>
                        <p class="text-sm font-semibold text-slate-700">View Timetable</p>
                        <p class="text-xs text-slate-400">Check your class schedule</p>
                    </div>
                    <i class="fa fa-chevron-right ml-auto text-slate-300 group-hover:text-slate-500 transition-all"></i>
                </a>
            </div>
        </div>
    </div>

    {{-- Footer Note --}}
    <div class="mt-5 p-4 bg-gradient-to-r from-blue-50 to-cyan-50 rounded-xl border border-blue-100">
        <div class="flex items-start gap-3">
            <div class="w-8 h-8 rounded-lg bg-gradient-to-tl from-blue-500 to-cyan-400 flex items-center justify-center flex-shrink-0 shadow-soft-sm">
                <i class="fa fa-info-circle text-black text-xs"></i>
            </div>
            <div>
                <p class="text-sm font-semibold text-blue-800">Portal Information</p>
                <p class="text-xs text-blue-600 mt-0.5">
                    For any issues with your account or academic records, please contact your class teacher or the school administration.
                </p>
            </div>
        </div>
    </div>

</div>

@endsection