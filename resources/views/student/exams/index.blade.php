@extends('layouts.admin')

@section('content')

@php $subdomain = request()->route('subdomain'); @endphp

<div class="w-full px-6 py-6 mx-auto">
    
    {{-- PAGE HEADER --}}
    <div class="flex flex-wrap items-center justify-between mb-6 -mx-3">
        <div class="px-3">
            <h3 class="text-2xl font-bold text-slate-700 mb-1">Exam Schedule</h3>
            <p class="text-sm text-slate-400">
                <i class="fa fa-home mr-1"></i> Dashboard
                <span class="mx-1 text-slate-300">/</span>
                <a href="{{ route('student.dashboard', $subdomain) }}" class="hover:text-slate-600">Student Portal</a>
                <span class="mx-1 text-slate-300">/</span>
                <span class="text-slate-600">Exam Schedule</span>
            </p>
        </div>
        <div class="px-3 mt-3 md:mt-0">
            <a href="{{ route('student.dashboard', $subdomain) }}"
               class="px-4 py-2 text-sm border border-gray-300 rounded-lg text-slate-600 hover:bg-gray-50 transition-all">
                <i class="fa fa-arrow-left mr-1"></i> Back to Dashboard
            </a>
        </div>
    </div>

    {{-- Exam Schedule Card --}}
    <div class="bg-white shadow-soft-xl rounded-2xl overflow-hidden">
        
        <div class="flex items-center gap-3 px-6 py-4 border-b border-gray-100">
            <div class="w-8 h-8 rounded-lg bg-gradient-to-tl from-red-500 to-rose-400 flex items-center justify-center shadow-soft-md">
                <i class="fa fa-file-alt text-white text-xs"></i>
            </div>
            <div>
                <h6 class="font-bold text-slate-700 mb-0">Exam Schedule</h6>
                <p class="text-xs text-slate-400 mt-0.5">Final examination timetable</p>
            </div>
        </div>

        @if($exams->isEmpty())
            <div class="p-12 text-center">
                <div class="w-20 h-20 rounded-2xl bg-gray-100 flex items-center justify-center mb-4 mx-auto">
                    <i class="fa fa-file-alt text-gray-400 text-3xl"></i>
                </div>
                <p class="text-slate-500 font-semibold text-lg">No exam schedule available</p>
                <p class="text-slate-400 text-sm mt-1">Exam schedule will appear here once published by the school.</p>
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="items-center w-full mb-0 align-top border-gray-200 text-slate-500">
                    <thead class="align-bottom bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xxs font-bold uppercase tracking-wider text-slate-400 opacity-70">Subject</th>
                            <th class="px-6 py-3 text-center text-xxs font-bold uppercase tracking-wider text-slate-400 opacity-70">Date</th>
                            <th class="px-6 py-3 text-center text-xxs font-bold uppercase tracking-wider text-slate-400 opacity-70">Time</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($exams as $exam)
                        <tr class="border-t border-gray-100 hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4 align-middle">
                                <div class="flex items-center gap-2">
                                    <div class="w-6 h-6 rounded-lg bg-gradient-to-tl from-indigo-500 to-purple-400 flex items-center justify-center">
                                        <i class="fa fa-book text-white text-xs"></i>
                                    </div>
                                    <span class="text-sm font-semibold text-slate-700">{{ $exam->subject->name ?? 'N/A' }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4 align-middle text-center">
                                <div class="flex items-center justify-center gap-1">
                                    <i class="fa fa-calendar-alt text-slate-400 text-xs"></i>
                                    <span class="text-sm text-slate-600">{{ \Carbon\Carbon::parse($exam->date)->format('d M Y') }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4 align-middle text-center">
                                <div class="flex items-center justify-center gap-1">
                                    <i class="fa fa-clock text-slate-400 text-xs"></i>
                                    <span class="text-sm text-slate-600">{{ $exam->start_time }} - {{ $exam->end_time }}</span>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif

    </div>

    {{-- Footer Note --}}
    <div class="mt-5 p-4 bg-gradient-to-r from-red-50 to-rose-50 rounded-xl border border-red-100">
        <div class="flex items-start gap-3">
            <div class="w-8 h-8 rounded-lg bg-gradient-to-tl from-red-500 to-rose-400 flex items-center justify-center flex-shrink-0">
                <i class="fa fa-info-circle text-white text-xs"></i>
            </div>
            <div>
                <p class="text-sm font-semibold text-red-800">Exam Information</p>
                <p class="text-xs text-red-600 mt-0.5">
                    Please arrive at least 30 minutes before each exam. Bring your student ID and necessary materials.
                </p>
            </div>
        </div>
    </div>

</div>

@endsection