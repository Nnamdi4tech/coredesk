@extends('layouts.admin')

@section('content')

@php $subdomain = request()->route('subdomain'); @endphp

<div class="w-full px-6 py-6 mx-auto">
    
    {{-- PAGE HEADER --}}
    <div class="flex flex-wrap items-center justify-between mb-6 -mx-3">
        <div class="px-3">
            <h3 class="text-2xl font-bold text-slate-700 mb-1">My Results</h3>
            <p class="text-sm text-slate-400">
                <i class="fa fa-home mr-1"></i> Dashboard
                <span class="mx-1 text-slate-300">/</span>
                <a href="{{ route('student.dashboard', $subdomain) }}" class="hover:text-slate-600">Student Portal</a>
                <span class="mx-1 text-slate-300">/</span>
                <span class="text-slate-600">My Results</span>
            </p>
        </div>
        <div class="px-3 mt-3 md:mt-0">
            <a href="{{ route('student.dashboard', $subdomain) }}"
               class="px-4 py-2 text-sm border border-gray-300 rounded-lg text-slate-600 hover:bg-gray-50 transition-all">
                <i class="fa fa-arrow-left mr-1"></i> Back to Dashboard
            </a>
        </div>
    </div>

    {{-- Results Card --}}
    <div class="bg-white shadow-soft-xl rounded-2xl overflow-hidden">
        
        <div class="flex items-center gap-3 px-6 py-4 border-b border-gray-100">
            <div class="w-8 h-8 rounded-lg bg-gradient-to-tl from-blue-500 to-cyan-400 flex items-center justify-center shadow-soft-md">
                <i class="fa fa-chart-line text-black text-xs"></i>
            </div>
            <div>
                <h6 class="font-bold text-slate-700 mb-0">Academic Performance</h6>
                <p class="text-xs text-slate-400 mt-0.5">{{ $student->name }} ({{ $student->student_id }})</p>
            </div>
        </div>

        {{-- FILTER SECTION --}}
        <div class="px-6 py-4 border-b border-gray-100 bg-gray-50">
            <form method="GET" class="flex flex-wrap items-end gap-4">
                <!-- class -->
                 <div class="flex-1 min-w-[150px]">
    <label class="block text-xs font-semibold text-slate-600 mb-1.5">
        <i class="fa fa-school mr-1 text-slate-400"></i> Class
    </label>
    <select name="class_id"
            class="text-sm w-full rounded-lg border border-gray-300 bg-white py-2 px-3 text-gray-700 focus:outline-none focus:border-fuchsia-300 transition-all">
        <option value="">All Classes</option>
        @foreach($classes as $class)
            <option value="{{ $class->id }}" {{ request('class_id') == $class->id ? 'selected' : '' }}>
                {{ $class->name }}
            </option>
        @endforeach
    </select>
</div>
<!-- class ends -->
                <div class="flex-1 min-w-[150px]">
                    <label class="block text-xs font-semibold text-slate-600 mb-1.5">
                        <i class="fa fa-calendar-alt mr-1 text-slate-400"></i> Term
                    </label>
                    <select name="term" 
                            class="text-sm w-full rounded-lg border border-gray-300 bg-white py-2 px-3 text-gray-700 focus:outline-none focus:border-fuchsia-300 transition-all">
                        <option value="">All Terms</option>
                        @foreach($terms as $t)
                            <option value="{{ $t }}" {{ request('term') == $t ? 'selected' : '' }}>
                                {{ $t }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="flex-1 min-w-[150px]">
                    <label class="block text-xs font-semibold text-slate-600 mb-1.5">
                        <i class="fa fa-calendar-week mr-1 text-slate-400"></i> Session
                    </label>
                    <select name="session" 
                            class="text-sm w-full rounded-lg border border-gray-300 bg-white py-2 px-3 text-gray-700 focus:outline-none focus:border-fuchsia-300 transition-all">
                        <option value="">All Sessions</option>
                        @foreach($sessions as $s)
                            <option value="{{ $s }}" {{ request('session') == $s ? 'selected' : '' }}>
                                {{ $s }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <button type="submit"
                            class="px-5 py-2 text-sm font-semibold text-black rounded-lg bg-gradient-to-tl from-blue-600 to-cyan-500 shadow-soft-md hover:shadow-soft-xl hover:scale-105 transition-all">
                        <i class="fa fa-filter mr-1"></i> Filter Results
                    </button>
                </div>

                @if(request('term') || request('session') || request('class_id'))
                    <div>
                        <a href="{{ route('student.results.index', $subdomain) }}"
                           class="px-5 py-2 text-sm font-semibold text-slate-600 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition-all">
                            <i class="fa fa-times mr-1"></i> Clear Filters
                        </a>
                    </div>
                @endif
            </form>
        </div>

        @if($results->count() > 0)
            <div class="overflow-x-auto">
                <table class="items-center w-full mb-0 align-top border-gray-200 text-slate-500">
                    <thead class="align-bottom bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xxs font-bold uppercase tracking-wider text-slate-400 opacity-70">Subject</th>
                            <th class="px-6 py-3 text-center text-xxs font-bold uppercase tracking-wider text-slate-400 opacity-70">CA1</th>
                            <th class="px-6 py-3 text-center text-xxs font-bold uppercase tracking-wider text-slate-400 opacity-70">CA2</th>
                            <th class="px-6 py-3 text-center text-xxs font-bold uppercase tracking-wider text-slate-400 opacity-70">Exam</th>
                            <th class="px-6 py-3 text-center text-xxs font-bold uppercase tracking-wider text-slate-400 opacity-70">Total</th>
                            <th class="px-6 py-3 text-center text-xxs font-bold uppercase tracking-wider text-slate-400 opacity-70">Grade</th>
                            <th class="px-6 py-3 text-center text-xxs font-bold uppercase tracking-wider text-slate-400 opacity-70">Class</th>
                            <th class="px-6 py-3 text-center text-xxs font-bold uppercase tracking-wider text-slate-400 opacity-70">Term</th>
                            <th class="px-6 py-3 text-center text-xxs font-bold uppercase tracking-wider text-slate-400 opacity-70">Session</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($results as $result)
@php
    // Calculate total score (out of 100)
    // CA1 + CA2 + Exam = Total (since CA3 is removed)
    $total = ($result->ca1 ?? 0) + ($result->ca2 ?? 0) + ($result->exam ?? 0);
    
    // Standard Grade Mapping (out of 100)
    if ($total >= 70) {
        $grade = 'A';
        $gradeColor = 'text-green-600 bg-green-50';
        $gradeRemark = 'Excellent';
    } elseif ($total >= 60) {
        $grade = 'B';
        $gradeColor = 'text-blue-600 bg-blue-50';
        $gradeRemark = 'Very Good';
    } elseif ($total >= 50) {
        $grade = 'C';
        $gradeColor = 'text-yellow-600 bg-yellow-50';
        $gradeRemark = 'Good';
    } elseif ($total >= 45) {
        $grade = 'D';
        $gradeColor = 'text-orange-600 bg-orange-50';
        $gradeRemark = 'Fair';
    } elseif ($total >= 40) {
        $grade = 'E';
        $gradeColor = 'text-purple-600 bg-purple-50';
        $gradeRemark = 'Pass';
    } else {
        $grade = 'F';
        $gradeColor = 'text-red-600 bg-red-50';
        $gradeRemark = 'Fail';
    }
@endphp
<tr class="border-t border-gray-100 hover:bg-gray-50 transition-colors">
    <td class="px-6 py-4 align-middle">
        <div class="flex items-center gap-2">
            <div class="w-6 h-6 rounded-lg bg-gradient-to-tl from-indigo-500 to-purple-400 flex items-center justify-center text-black text-xs font-bold">
                {{ strtoupper(substr($result->subject->name ?? 'N/A', 0, 1)) }}
            </div>
            <span class="text-sm font-semibold text-slate-700">{{ $result->subject->name ?? 'N/A' }}</span>
        </div>
    </td>
    <td class="px-6 py-4 align-middle text-center text-sm">{{ $result->ca1 ?? '—' }} / 20</td>
    <td class="px-6 py-4 align-middle text-center text-sm">{{ $result->ca2 ?? '—' }} / 20</td>
    <td class="px-6 py-4 align-middle text-center text-sm">{{ $result->exam ?? '—' }} / 60</td>
    <td class="px-6 py-4 align-middle text-center text-sm font-semibold">{{ $total ?? '—' }} / 100</td>
    <td class="px-6 py-4 align-middle text-center">
        <div class="flex flex-col items-center">
            <span class="inline-flex items-center justify-center w-8 h-8 text-sm font-bold rounded-full {{ $gradeColor }}">
                {{ $grade }}
            </span>
            <span class="text-xs text-slate-400 mt-1">{{ $gradeRemark }}</span>
        </div>
    </td>
    <td class="px-6 py-4 align-middle text-center text-sm">
       <span class="px-2 py-1 text-xs rounded-full bg-indigo-50 text-indigo-600">
         {{ $result->schoolClass->name ?? 'N/A' }}
       </span>
    </td>
    <td class="px-6 py-4 align-middle text-center text-sm">
        <span class="px-2 py-1 text-xs rounded-full bg-gray-100 text-gray-600">
            {{ $result->term ?? 'N/A' }}
        </span>
    </td>
    <td class="px-6 py-4 align-middle text-center text-sm">
        <span class="px-2 py-1 text-xs rounded-full bg-gray-100 text-gray-600">
            {{ $result->session ?? 'N/A' }}
        </span>
    </td>
</tr>
@endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="p-12 text-center">
                <div class="w-20 h-20 rounded-2xl bg-gray-100 flex items-center justify-center mb-4 mx-auto">
                    <i class="fa fa-chart-line text-gray-400 text-3xl"></i>
                </div>
                <p class="text-slate-500 font-semibold text-lg">No results found</p>
                <p class="text-slate-400 text-sm mt-1">Your results will appear here once published by your teacher.</p>
            </div>
        @endif

    </div>

</div>

@endsection