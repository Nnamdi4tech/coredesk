@extends('layouts.admin')

@section('content')

@php $subdomain = request()->route('subdomain'); @endphp

<div class="w-full px-6 py-6 mx-auto">
    
    {{-- PAGE HEADER --}}
    <div class="flex flex-wrap items-center justify-between mb-6 -mx-3">
        <div class="px-3">
            <h3 class="text-2xl font-bold text-slate-700 mb-1">Test Schedule</h3>
            <p class="text-sm text-slate-400">
                <i class="fa fa-home mr-1"></i> Dashboard
                <span class="mx-1 text-slate-300">/</span>
                <a href="{{ route('student.dashboard', $subdomain) }}" class="hover:text-slate-600">Student Portal</a>
                <span class="mx-1 text-slate-300">/</span>
                <span class="text-slate-600">Test Schedule</span>
            </p>
        </div>
        <div class="px-3 mt-3 md:mt-0">
            <a href="{{ route('student.dashboard', $subdomain) }}"
               class="px-4 py-2 text-sm border border-gray-300 rounded-lg text-slate-600 hover:bg-gray-50 transition-all">
                <i class="fa fa-arrow-left mr-1"></i> Back to Dashboard
            </a>
        </div>
    </div>

    {{-- Test Schedule Card --}}
    <div class="bg-white shadow-soft-xl rounded-2xl overflow-hidden">
        
        <div class="flex items-center gap-3 px-6 py-4 border-b border-gray-100">
            <div class="w-8 h-8 rounded-lg bg-gradient-to-tl from-amber-500 to-orange-400 flex items-center justify-center shadow-soft-md">
                <i class="fa fa-pen-alt text-black text-xs"></i>
            </div>
            <div>
                <h6 class="font-bold text-slate-700 mb-0">Test Schedule</h6>
                <p class="text-xs text-slate-400 mt-0.5">Upcoming tests and quizzes</p>
            </div>
        </div>

        @if($tests->isEmpty())
            <div class="p-12 text-center">
                <div class="w-20 h-20 rounded-2xl bg-gray-100 flex items-center justify-center mb-4 mx-auto">
                    <i class="fa fa-pen-alt text-gray-400 text-3xl"></i>
                </div>
                <p class="text-slate-500 font-semibold text-lg">No test schedule available</p>
                <p class="text-slate-400 text-sm mt-1">Test schedule will appear here once published by the school.</p>
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="items-center w-full mb-0 align-top border-gray-200 text-slate-500">
                    <thead class="align-bottom bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xxs font-bold uppercase tracking-wider text-slate-400 opacity-70">Subject</th>
                            <th class="px-6 py-3 text-center text-xxs font-bold uppercase tracking-wider text-slate-400 opacity-70">Type</th>
                            <th class="px-6 py-3 text-center text-xxs font-bold uppercase tracking-wider text-slate-400 opacity-70">Date</th>
                            <th class="px-6 py-3 text-center text-xxs font-bold uppercase tracking-wider text-slate-400 opacity-70">Time</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($tests as $test)
                        <tr class="border-t border-gray-100 hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4 align-middle">
                                <div class="flex items-center gap-2">
                                    <div class="w-6 h-6 rounded-lg bg-gradient-to-tl from-indigo-500 to-purple-400 flex items-center justify-center">
                                        <i class="fa fa-book text-black text-xs"></i>
                                    </div>
                                    <span class="text-sm font-semibold text-slate-700">{{ $test->subject->name ?? 'N/A' }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4 align-middle text-center">
                                <span class="px-3 py-1 text-xs font-semibold rounded-full 
                                    {{ $test->type == 'Quiz' ? 'bg-purple-50 text-purple-600' : 
                                       ($test->type == 'Mid-Term' ? 'bg-blue-50 text-blue-600' : 'bg-amber-50 text-amber-600') }}">
                                    {{ $test->type }}
                                </span>
                            </td>
                            <td class="px-6 py-4 align-middle text-center">
                                <div class="flex items-center justify-center gap-1">
                                    <i class="fa fa-calendar-alt text-slate-400 text-xs"></i>
                                    <span class="text-sm text-slate-600">{{ $test->date }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4 align-middle text-center">
                                <div class="flex items-center justify-center gap-1">
                                    <i class="fa fa-clock text-slate-400 text-xs"></i>
                                    <span class="text-sm text-slate-600">{{ $test->start_time }} - {{ $test->end_time }}</span>
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
    <div class="mt-5 p-4 bg-gradient-to-r from-amber-50 to-orange-50 rounded-xl border border-amber-100">
        <div class="flex items-start gap-3">
            <div class="w-8 h-8 rounded-lg bg-gradient-to-tl from-amber-500 to-orange-400 flex items-center justify-center flex-shrink-0">
                <i class="fa fa-info-circle text-black text-xs"></i>
            </div>
            <div>
                <p class="text-sm font-semibold text-amber-800">Test Information</p>
                <p class="text-xs text-amber-600 mt-0.5">
                    Please check this schedule regularly for updates. Contact your teacher if you have any conflicts.
                </p>
            </div>
        </div>
    </div>

</div>

@endsection