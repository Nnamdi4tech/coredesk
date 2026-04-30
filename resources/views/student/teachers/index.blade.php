@extends('layouts.admin')

@section('content')

@php $subdomain = request()->route('subdomain'); @endphp

<div class="w-full px-6 py-6 mx-auto">
    
    {{-- PAGE HEADER --}}
    <div class="flex flex-wrap items-center justify-between mb-6 -mx-3">
        <div class="px-3">
            <h3 class="text-2xl font-bold text-slate-700 mb-1">My Teachers</h3>
            <p class="text-sm text-slate-400">
                <i class="fa fa-home mr-1"></i> Dashboard
                <span class="mx-1 text-slate-300">/</span>
                <a href="{{ route('student.dashboard', $subdomain) }}" class="hover:text-slate-600">Student Portal</a>
                <span class="mx-1 text-slate-300">/</span>
                <span class="text-slate-600">My Teachers</span>
            </p>
        </div>
        <div class="px-3 mt-3 md:mt-0">
            <a href="{{ route('student.dashboard', $subdomain) }}"
               class="px-4 py-2 text-sm border border-gray-300 rounded-lg text-slate-600 hover:bg-gray-50 transition-all">
                <i class="fa fa-arrow-left mr-1"></i> Back to Dashboard
            </a>
        </div>
    </div>

    {{-- Teachers Card --}}
    <div class="bg-white shadow-soft-xl rounded-2xl overflow-hidden">
        
        <div class="flex items-center gap-3 px-6 py-4 border-b border-gray-100">
            <div class="w-8 h-8 rounded-lg bg-gradient-to-tl from-blue-500 to-cyan-400 flex items-center justify-center shadow-soft-md">
                <i class="fa fa-chalkboard-user text-black text-xs"></i>
            </div>
            <div>
                <h6 class="font-bold text-slate-700 mb-0">My Teachers</h6>
                <p class="text-xs text-slate-400 mt-0.5">{{ $student->name ?? 'Student' }} ({{ $teachers->count() }} teachers)</p>
            </div>
        </div>

        @if($teachers->isEmpty())
            <div class="p-12 text-center">
                <div class="w-20 h-20 rounded-2xl bg-gray-100 flex items-center justify-center mb-4 mx-auto">
                    <i class="fa fa-chalkboard-user text-gray-400 text-3xl"></i>
                </div>
                <p class="text-slate-500 font-semibold text-lg">No teachers found</p>
                <p class="text-slate-400 text-sm mt-1">Your teachers will appear here once assigned to your class.</p>
            </div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 p-6">
                @foreach($teachers as $teacher)
                    @php
                        $teacherName = $teacher->user->name ?? $teacher->name ?? 'N/A';
                        $teacherInitial = strtoupper(substr($teacherName, 0, 2));
                        $teacherEmail = $teacher->user->email ?? $teacher->email ?? 'N/A';
                        $teacherSubject = $teacher->subject ?? 'Subject Teacher';
                    @endphp
                    <div class="relative flex flex-col min-w-0 break-words bg-gradient-to-r from-blue-50 to-cyan-50 rounded-xl border border-blue-100 hover:shadow-soft-md transition-all group">
                        <div class="flex-auto p-4">
                            <div class="flex items-center gap-3">
                                <div class="w-12 h-12 rounded-xl bg-gradient-to-tl from-blue-500 to-cyan-400 flex items-center justify-center shadow-soft-sm group-hover:scale-110 transition-all">
                                    <span class="text-black text-sm font-bold">{{ $teacherInitial }}</span>
                                </div>
                                <div class="flex-1">
                                    <h5 class="font-bold text-slate-700 mb-0 text-sm">{{ $teacherName }}</h5>
                                    <p class="text-xs text-slate-500 mt-0.5">{{ $teacherSubject }}</p>
                                    <p class="text-xs text-slate-400 mt-0.5">
                                        <i class="fa fa-envelope mr-1"></i> {{ $teacherEmail }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif

    </div>

    {{-- Footer Note --}}
    <div class="mt-5 p-4 bg-gradient-to-r from-blue-50 to-cyan-50 rounded-xl border border-blue-100">
        <div class="flex items-start gap-3">
            <div class="w-8 h-8 rounded-lg bg-gradient-to-tl from-blue-500 to-cyan-400 flex items-center justify-center flex-shrink-0 shadow-soft-sm">
                <i class="fa fa-info-circle text-black text-xs"></i>
            </div>
            <div>
                <p class="text-sm font-semibold text-blue-800">Teacher Information</p>
                <p class="text-xs text-blue-600 mt-0.5">
                    These are the teachers assigned to teach your class. You can contact them through the school administration if needed.
                </p>
            </div>
        </div>
    </div>

</div>

@endsection