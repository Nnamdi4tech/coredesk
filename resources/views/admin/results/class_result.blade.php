@extends('layouts.admin')

@section('content')

@php $subdomain = request()->route('subdomain'); @endphp

<div class="w-full px-6 py-6 mx-auto">
    
    {{-- PAGE HEADER --}}
    <div class="flex flex-wrap items-center justify-between mb-6 -mx-3">
        <div class="px-3">
            <h3 class="text-2xl font-bold text-slate-700 mb-1">Class Result Sheet</h3>
            <p class="text-sm text-slate-400">
                <i class="fa fa-home mr-1"></i> Dashboard
                <span class="mx-1 text-slate-300">/</span>
                <a href="{{ route('tenant.admin.dashboard', $subdomain) }}" class="hover:text-slate-600">Admin</a>
                <span class="mx-1 text-slate-300">/</span>
                <span class="text-slate-600">Class Result</span>
            </p>
        </div>
        <div class="px-3 mt-3 md:mt-0 flex gap-2">
    <button onclick="window.history.back()"
            class="px-4 py-2 text-sm font-semibold text-slate-600 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 hover:border-gray-400 transition-all">
        <i class="fa fa-arrow-left mr-1"></i> Go Back
    </button>
    <button onclick="window.print()"
            class="px-4 py-2 text-sm font-semibold text-black rounded-lg bg-gradient-to-tl from-green-600 to-emerald-500 shadow-soft-md hover:shadow-soft-xl hover:scale-105 transition-all">
        <i class="fa fa-print mr-1"></i> Print Class Result
    </button>
</div>
    </div>

    {{-- CLASS RESULT CARD --}}
    <div class="bg-white shadow-soft-xl rounded-2xl overflow-hidden">
        
        {{-- Card Header --}}
        <div class="">
            <h2 class="text-2xl font-bold text-black text-center mb-1">CLASS RESULT SHEET</h2>
            <p class="text-center text-black text-xs">Academic Performance Summary</p>
        </div>

        {{-- Info Section --}}
        <div class="flex flex-wrap justify-between gap-4 px-6 py-5 border-b border-gray-100 bg-gray-50">
            <div>
                <div class="flex items-center gap-2 mb-2">
                    <div class="w-8 h-8 rounded-lg bg-gradient-to-tl from-purple-500 to-pink-400 flex items-center justify-center shadow-soft-sm">
                        <i class="fa fa-chalkboard text-black text-xs"></i>
                    </div>
                    <span class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Class Information</span>
                </div>
                <p class="text-sm text-slate-700"><strong class="font-semibold">Class:</strong> {{ $class->name ?? 'N/A' }}</p>
            </div>
            
            <div>
                <div class="flex items-center gap-2 mb-2">
                    <div class="w-8 h-8 rounded-lg bg-gradient-to-tl from-blue-500 to-cyan-400 flex items-center justify-center shadow-soft-sm">
                        <i class="fa fa-calendar-alt text-black text-xs"></i>
                    </div>
                    <span class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Academic Details</span>
                </div>
                <p class="text-sm text-slate-700 mb-1"><strong class="font-semibold">Term/Semester:</strong> {{ ucfirst($term) }} Term</p>
                <p class="text-sm text-slate-700"><strong class="font-semibold">Session:</strong> {{ $session }}</p>
            </div>

            <div>
                <div class="flex items-center gap-2 mb-2">
                    <div class="w-8 h-8 rounded-lg bg-gradient-to-tl from-green-500 to-emerald-400 flex items-center justify-center shadow-soft-sm">
                        <i class="fa fa-users text-black text-xs"></i>
                    </div>
                    <span class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Statistics</span>
                </div>
                <p class="text-sm text-slate-700"><strong class="font-semibold">Total Students:</strong> {{ count($final) }}</p>
                <p class="text-sm text-slate-700"><strong class="font-semibold">Total Subjects:</strong> {{ count($subjects) }}</p>
            </div>
        </div>

        {{-- Results Table --}}
        <div class="overflow-x-auto">
            <table class="items-center w-full mb-0 align-top border-gray-200 text-slate-500">
                <thead class="align-bottom bg-gray-50">
                    <tr>
                        <th class="px-4 py-3 text-center text-xxs font-bold uppercase tracking-wider text-slate-400 opacity-70">#</th>
                        <th class="px-4 py-3 text-left text-xxs font-bold uppercase tracking-wider text-slate-400 opacity-70">Student Name</th>
                        @foreach($subjects as $subject)
                            <th class="px-4 py-3 text-center text-xxs font-bold uppercase tracking-wider text-slate-400 opacity-70">
                                {{ $subject->name }}
                            </th>
                        @endforeach
                        <th class="px-4 py-3 text-center text-xxs font-bold uppercase tracking-wider text-slate-400 opacity-70">Total</th>
                        <th class="px-4 py-3 text-center text-xxs font-bold uppercase tracking-wider text-slate-400 opacity-70">Average</th>
                        <th class="px-4 py-3 text-center text-xxs font-bold uppercase tracking-wider text-slate-400 opacity-70">Position</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($final as $index => $data)
                    @php
                        $positionColor = $data['position'] == 1 ? 'text-amber-500' : ($data['position'] == 2 ? 'text-slate-500' : ($data['position'] == 3 ? 'text-orange-500' : 'text-slate-400'));
                    @endphp
                    <tr class="border-t border-gray-100 hover:bg-gray-50 transition-colors">
                        <td class="px-4 py-3 align-middle text-center text-sm font-semibold text-slate-500">
                            {{ $index + 1 }}
                        </td>
                        <td class="px-4 py-3 align-middle">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-xl bg-gradient-to-tl from-blue-500 to-cyan-400 flex items-center justify-center text-black text-xs font-bold shadow-soft-md flex-shrink-0">
                                    {{ strtoupper(substr($data['student']->name, 0, 2)) }}
                                </div>
                                <div>
                                    <p class="text-sm font-semibold text-slate-700 mb-0">{{ $data['student']->name }}</p>
                                    <p class="text-xs text-slate-400">{{ $data['student']->student_id ?? 'N/A' }}</p>
                                </div>
                            </div>
                        </td>
                        @foreach($subjects as $subject)
                            <td class="px-4 py-3 align-middle text-center text-sm font-medium">
                                @php $score = $data['subjects'][$subject->name] ?? 0; @endphp
                                <span class="{{ $score >= 70 ? 'text-green-600' : ($score >= 50 ? 'text-blue-600' : ($score >= 40 ? 'text-orange-600' : 'text-red-600')) }}">
                                    {{ $score }}
                                </span>
                            </td>
                        @endforeach
                        <td class="px-4 py-3 align-middle text-center text-sm font-bold text-slate-700">
                            {{ $data['total'] }}
                        </td>
                        <td class="px-4 py-3 align-middle text-center text-sm font-semibold">
                            {{ number_format($data['average'], 2) }}
                        </td>
                        <td class="px-4 py-3 align-middle text-center">
                            <span class="inline-flex items-center justify-center w-8 h-8 text-sm font-bold rounded-full bg-gray-100 {{ $positionColor }}">
                                {{ $data['position'] }}
                            </span>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- Class Summary Statistics --}}
        @php
            $totalScores = collect($final)->pluck('total');
            $classAverage = $totalScores->avg();
            $highestScore = $totalScores->max();
            $lowestScore = $totalScores->min();
            $passCount = $totalScores->filter(fn($score) => ($score / (count($subjects) * 160)) * 100 >= 50)->count();
        @endphp
        
        <div class="flex flex-wrap -mx-3 mt-5 px-4 py-4 bg-gray-50 border-t border-gray-200">
            <div class="w-full max-w-full px-3 mb-4 sm:w-1/2 sm:flex-none xl:mb-0 xl:w-1/4">
                <div class="relative flex flex-col min-w-0 break-words bg-white shadow-soft-sm rounded-xl bg-clip-border">
                    <div class="flex-auto p-3">
                        <div class="flex flex-row -mx-3">
                            <div class="flex-none w-2/3 max-w-full px-3">
                                <div>
                                    <p class="mb-0 font-sans text-xs font-semibold leading-normal text-slate-500">
                                        Class Average
                                    </p>
                                    <h5 class="mb-0 font-bold text-slate-700 text-lg">
                                        {{ number_format($classAverage, 2) }}
                                    </h5>
                                </div>
                            </div>
                            <div class="px-3 text-right basis-1/3">
                                <div class="inline-block w-10 h-10 text-center rounded-lg bg-gradient-to-tl from-blue-500 to-cyan-400">
                                    <i class="fa fa-chart-line text-md relative top-2.5 text-black"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="w-full max-w-full px-3 mb-4 sm:w-1/2 sm:flex-none xl:mb-0 xl:w-1/4">
                <div class="relative flex flex-col min-w-0 break-words bg-white shadow-soft-sm rounded-xl bg-clip-border">
                    <div class="flex-auto p-3">
                        <div class="flex flex-row -mx-3">
                            <div class="flex-none w-2/3 max-w-full px-3">
                                <div>
                                    <p class="mb-0 font-sans text-xs font-semibold leading-normal text-slate-500">
                                        Highest Score
                                    </p>
                                    <h5 class="mb-0 font-bold text-slate-700 text-lg">
                                        {{ $highestScore }}
                                    </h5>
                                </div>
                            </div>
                            <div class="px-3 text-right basis-1/3">
                                <div class="inline-block w-10 h-10 text-center rounded-lg bg-gradient-to-tl from-green-500 to-emerald-400">
                                    <i class="fa fa-trophy text-md relative top-2.5 text-black"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="w-full max-w-full px-3 mb-4 sm:w-1/2 sm:flex-none xl:mb-0 xl:w-1/4">
                <div class="relative flex flex-col min-w-0 break-words bg-white shadow-soft-sm rounded-xl bg-clip-border">
                    <div class="flex-auto p-3">
                        <div class="flex flex-row -mx-3">
                            <div class="flex-none w-2/3 max-w-full px-3">
                                <div>
                                    <p class="mb-0 font-sans text-xs font-semibold leading-normal text-slate-500">
                                        Lowest Score
                                    </p>
                                    <h5 class="mb-0 font-bold text-slate-700 text-lg">
                                        {{ $lowestScore }}
                                    </h5>
                                </div>
                            </div>
                            <div class="px-3 text-right basis-1/3">
                                <div class="inline-block w-10 h-10 text-center rounded-lg bg-gradient-to-tl from-orange-500 to-amber-400">
                                    <i class="fa fa-chart-line text-md relative top-2.5 text-black"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="w-full max-w-full px-3 mb-4 sm:w-1/2 sm:flex-none xl:mb-0 xl:w-1/4">
                <div class="relative flex flex-col min-w-0 break-words bg-white shadow-soft-sm rounded-xl bg-clip-border">
                    <div class="flex-auto p-3">
                        <div class="flex flex-row -mx-3">
                            <div class="flex-none w-2/3 max-w-full px-3">
                                <div>
                                    <p class="mb-0 font-sans text-xs font-semibold leading-normal text-slate-500">
                                        Pass Rate
                                    </p>
                                    <h5 class="mb-0 font-bold text-slate-700 text-lg">
                                        {{ number_format(($passCount / max(count($final), 1)) * 100, 1) }}%
                                    </h5>
                                </div>
                            </div>
                            <div class="px-3 text-right basis-1/3">
                                <div class="inline-block w-10 h-10 text-center rounded-lg bg-gradient-to-tl from-purple-500 to-pink-400">
                                    <i class="fa fa-check-circle text-md relative top-2.5 text-black"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Footer Note --}}
        <div class="px-6 py-3 bg-white border-t border-gray-100 text-center">
            <p class="text-xs text-slate-400">
                <i class="fa fa-check-circle text-green-500 mr-1"></i>
                This is a computer-generated document. For verification, please contact the administration.
            </p>
        </div>

    </div>

</div>

{{-- Print Styles --}}
<style media="print">
    @media print {
        body * {
            visibility: hidden;
        }
        .bg-white, .bg-white * {
            visibility: visible;
        }
        .bg-white {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            margin: 0;
            padding: 20px;
            box-shadow: none;
        }
        button, .no-print {
            display: none !important;
        }
        .bg-gradient-to-r, .bg-gray-50 {
            background: white !important;
        }
        table {
            page-break-inside: avoid;
        }
    }
</style>

@endsection 