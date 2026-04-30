@extends('layouts.admin')

@section('content')

@php $subdomain = request()->route('subdomain'); @endphp

<div class="w-full px-6 py-6 mx-auto">
    
    {{-- PAGE HEADER --}}
    <div class="flex flex-wrap items-center justify-between mb-6 -mx-3">
        <div class="px-3">
            <h3 class="text-2xl font-bold text-slate-700 mb-1">Class Timetable</h3>
            <p class="text-sm text-slate-400">
                <i class="fa fa-home mr-1"></i> Dashboard
                <span class="mx-1 text-slate-300">/</span>
                <a href="{{ route('student.dashboard', $subdomain) }}" class="hover:text-slate-600">Student Portal</a>
                <span class="mx-1 text-slate-300">/</span>
                <span class="text-slate-600">Timetable</span>
            </p>
        </div>
        <div class="px-3 mt-3 md:mt-0">
            <a href="{{ route('student.dashboard', $subdomain) }}"
               class="px-4 py-2 text-sm border border-gray-300 rounded-lg text-slate-600 hover:bg-gray-50 transition-all">
                <i class="fa fa-arrow-left mr-1"></i> Back to Dashboard
            </a>
        </div>
    </div>

    {{-- Timetable Card --}}
    <div class="bg-white shadow-soft-xl rounded-2xl overflow-hidden">
        
        <div class="flex items-center gap-3 px-6 py-4 border-b border-gray-100">
            <div class="w-8 h-8 rounded-lg bg-gradient-to-tl from-purple-500 to-pink-400 flex items-center justify-center shadow-soft-md">
                <i class="fa fa-calendar-alt text-black text-xs"></i>
            </div>
            <div>
                <h6 class="font-bold text-slate-700 mb-0">Class Timetable</h6>
                <p class="text-xs text-slate-400 mt-0.5">{{ $student->name ?? 'Student' }} - {{ $student->schoolClass->name ?? 'Class' }}</p>
            </div>
        </div>

        @if($timetable->isEmpty())
            <div class="p-12 text-center">
                <div class="w-20 h-20 rounded-2xl bg-gray-100 flex items-center justify-center mb-4 mx-auto">
                    <i class="fa fa-calendar-alt text-gray-400 text-3xl"></i>
                </div>
                <p class="text-slate-500 font-semibold text-lg">No timetable available</p>
                <p class="text-slate-400 text-sm mt-1">Your class timetable will appear here once published by the school.</p>
            </div>
        @else
            <div class="p-6">
                @foreach($timetable as $day => $entries)
                    <div class="mb-8">
                        {{-- Day Header --}}
                        <div class="flex items-center gap-2 mb-4 pb-2 border-b-2 border-blue-200">
                            <div class="w-8 h-8 rounded-lg bg-gradient-to-tl from-blue-500 to-cyan-400 flex items-center justify-center">
                                <i class="fa fa-sun text-black text-xs"></i>
                            </div>
                            <h4 class="text-lg font-bold text-slate-700">{{ $day }}</h4>
                            <span class="text-xs text-slate-400 ml-2">{{ count($entries) }} classes</span>
                        </div>

                        {{-- Table for each day --}}
                        <div class="overflow-x-auto">
                            <table class="items-center w-full mb-0 align-top border-gray-200 text-slate-500">
                                <thead class="align-bottom bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xxs font-bold uppercase tracking-wider text-slate-400 opacity-70">Time</th>
                                        <th class="px-6 py-3 text-left text-xxs font-bold uppercase tracking-wider text-slate-400 opacity-70">Subject</th>
                                        <th class="px-6 py-3 text-left text-xxs font-bold uppercase tracking-wider text-slate-400 opacity-70">Teacher</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($entries as $entry)
                                    <tr class="border-t border-gray-100 hover:bg-gray-50 transition-colors">
                                        <td class="px-6 py-4 align-middle">
                                            <div class="flex items-center gap-2">
                                                <div class="w-6 h-6 rounded-lg bg-gradient-to-tl from-amber-500 to-orange-400 flex items-center justify-center">
                                                    <i class="fa fa-clock text-black text-xs"></i>
                                                </div>
                                                <span class="text-sm font-medium text-slate-700">{{ $entry->start_time }} - {{ $entry->end_time }}</span>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 align-middle">
                                            <div class="flex items-center gap-2">
                                                <div class="w-6 h-6 rounded-lg bg-gradient-to-tl from-indigo-500 to-purple-400 flex items-center justify-center">
                                                    <i class="fa fa-book text-black text-xs"></i>
                                                </div>
                                                <span class="text-sm font-semibold text-slate-700">{{ $entry->subject->name ?? 'N/A' }}</span>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 align-middle">
                                            <div class="flex items-center gap-2">
                                                <div class="w-6 h-6 rounded-lg bg-gradient-to-tl from-blue-500 to-cyan-400 flex items-center justify-center">
                                                    <i class="fa fa-chalkboard-user text-black text-xs"></i>
                                                </div>
                                                <span class="text-sm text-slate-600">{{ $entry->teacher->name ?? 'N/A' }}</span>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
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
                <p class="text-sm font-semibold text-blue-800">Timetable Information</p>
                <p class="text-xs text-blue-600 mt-0.5">
                    This timetable is subject to change. Please check regularly for updates. For any changes or conflicts, contact your class teacher.
                </p>
            </div>
        </div>
    </div>

</div>

@endsection