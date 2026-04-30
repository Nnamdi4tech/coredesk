@extends('layouts.admin')

@section('content')

@php $subdomain = request()->route('subdomain'); @endphp

<div class="w-full px-6 py-6 mx-auto">

    {{-- PAGE HEADER --}}
    <div class="flex flex-wrap items-center justify-between mb-6 -mx-3">
        <div class="px-3">
            <h3 class="text-2xl font-bold text-slate-700 mb-1">Results</h3>
            <p class="text-sm text-slate-400">
                <i class="fa fa-home mr-1"></i> Dashboard
                <span class="mx-1 text-slate-300">/</span>
                <a href="{{ route('tenant.teacher.dashboard', $subdomain) }}" class="hover:text-slate-600">Teacher</a>
                <span class="mx-1 text-slate-300">/</span>
                <span class="text-slate-600">My Results</span>
            </p>
        </div>
        <div class="px-3 flex gap-3 mt-3 md:mt-0">
            <a href="{{ route('tenant.teacher.results.bulk', $subdomain) }}"
               class="px-5 py-2 text-sm font-semibold text-white rounded-lg bg-gradient-to-tl from-blue-600 to-cyan-400 shadow-soft-md hover:shadow-soft-xl hover:scale-105 transition-all">
                <i class="fa fa-table mr-1 text-white"></i> Bulk Entry
            </a>
            <a href="{{ route('tenant.teacher.results.create', $subdomain) }}"
               class="px-5 py-2 text-sm font-semibold text-white rounded-lg bg-gradient-to-tl from-gray-900 to-slate-700 shadow-soft-md hover:shadow-soft-xl hover:scale-105 transition-all">
                <i class="fa fa-plus mr-1 text-white"></i> Single Entry
            </a>
        </div>
    </div>

    {{-- SUCCESS / ERROR MESSAGES --}}
    @if(session('success'))
        <div class="p-4 mb-6 text-sm text-green-700 bg-green-50 border border-green-200 rounded-2xl flex items-center gap-3">
            <div class="w-8 h-8 rounded-lg bg-gradient-to-tl from-green-500 to-emerald-400 flex items-center justify-center flex-shrink-0">
                <i class="fa fa-check text-primary text-xs"></i>
            </div>
            <p class="font-semibold">{{ session('success') }}</p>
            <button onclick="this.parentElement.remove()" class="ml-auto text-green-400 hover:text-green-600">
                <i class="fa fa-times text-xs"></i>
            </button>
        </div>
    @endif

    @if(session('error'))
        <div class="p-4 mb-6 text-sm text-red-700 bg-red-50 border border-red-200 rounded-2xl flex items-center gap-3">
            <div class="w-8 h-8 rounded-lg bg-gradient-to-tl from-red-500 to-rose-400 flex items-center justify-center flex-shrink-0">
                <i class="fa fa-exclamation-circle text-primary text-xs"></i>
            </div>
            <p class="font-semibold">{{ session('error') }}</p>
            <button onclick="this.parentElement.remove()" class="ml-auto text-red-400 hover:text-red-600">
                <i class="fa fa-times text-xs"></i>
            </button>
        </div>
    @endif

    {{-- STAT CARDS ROW 1 — 4 CARDS --}}
<div class="flex flex-wrap -mx-3 mb-6">
    
    <!-- card1 - Total Results -->
    <div class="w-full max-w-full px-3 mb-6 sm:w-1/2 sm:flex-none xl:mb-0 xl:w-1/4">
        <div class="relative flex flex-col min-w-0 break-words bg-white shadow-soft-xl rounded-2xl bg-clip-border">
            <div class="flex-auto p-4">
                <div class="flex flex-row -mx-3">
                    <div class="flex-none w-2/3 max-w-full px-3">
                        <div>
                            <p class="mb-0 font-sans text-sm font-semibold leading-normal">Total Results</p>
                            <h5 class="mb-0 font-bold">
                                {{ $results->count() }}
                                <span class="text-sm leading-normal font-weight-bolder text-blue-500">entries</span>
                            </h5>
                        </div>
                    </div>
                    <div class="px-3 text-right basis-1/3">
                        <div class="inline-block w-12 h-12 text-center rounded-lg bg-gradient-to-tl from-blue-500 to-cyan-400">
                            <i class="fa fa-star text-lg relative top-3.5 text-black"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- card2 - Submitted -->
    <div class="w-full max-w-full px-3 mb-6 sm:w-1/2 sm:flex-none xl:mb-0 xl:w-1/4">
        <div class="relative flex flex-col min-w-0 break-words bg-white shadow-soft-xl rounded-2xl bg-clip-border">
            <div class="flex-auto p-4">
                <div class="flex flex-row -mx-3">
                    <div class="flex-none w-2/3 max-w-full px-3">
                        <div>
                            <p class="mb-0 font-sans text-sm font-semibold leading-normal">Submitted</p>
                            <h5 class="mb-0 font-bold">
                                {{ $results->where('submitted', true)->count() }}
                                <span class="text-sm leading-normal font-weight-bolder text-green-500">approved</span>
                            </h5>
                        </div>
                    </div>
                    <div class="px-3 text-right basis-1/3">
                        <div class="inline-block w-12 h-12 text-center rounded-lg bg-gradient-to-tl from-green-500 to-emerald-400">
                            <i class="fa fa-check-circle text-lg relative top-3.5 text-black"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- card3 - Pending -->
    <div class="w-full max-w-full px-3 mb-6 sm:w-1/2 sm:flex-none xl:mb-0 xl:w-1/4">
        <div class="relative flex flex-col min-w-0 break-words bg-white shadow-soft-xl rounded-2xl bg-clip-border">
            <div class="flex-auto p-4">
                <div class="flex flex-row -mx-3">
                    <div class="flex-none w-2/3 max-w-full px-3">
                        <div>
                            <p class="mb-0 font-sans text-sm font-semibold leading-normal">Pending</p>
                            <h5 class="mb-0 font-bold">
                                {{ $results->where('submitted', false)->count() }}
                                <span class="text-sm leading-normal font-weight-bolder text-orange-500">awaiting</span>
                            </h5>
                        </div>
                    </div>
                    <div class="px-3 text-right basis-1/3">
                        <div class="inline-block w-12 h-12 text-center rounded-lg bg-gradient-to-tl from-orange-500 to-yellow-400">
                            <i class="fa fa-clock text-lg relative top-3.5 text-black"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- card4 - Grade A -->
    <div class="w-full max-w-full px-3 sm:w-1/2 sm:flex-none xl:w-1/4">
        <div class="relative flex flex-col min-w-0 break-words bg-white shadow-soft-xl rounded-2xl bg-clip-border">
            <div class="flex-auto p-4">
                <div class="flex flex-row -mx-3">
                    <div class="flex-none w-2/3 max-w-full px-3">
                        <div>
                            <p class="mb-0 font-sans text-sm font-semibold leading-normal">Grade A</p>
                            <h5 class="mb-0 font-bold">
                                {{ $results->where('grade', 'A')->count() }}
                                <span class="text-sm leading-normal font-weight-bolder text-purple-500">excellent</span>
                            </h5>
                        </div>
                    </div>
                    <div class="px-3 text-right basis-1/3">
                        <div class="inline-block w-12 h-12 text-center rounded-lg bg-gradient-to-tl from-purple-600 to-pink-500">
                            <i class="fa fa-trophy text-lg relative top-3.5 text-black"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

{{-- STAT CARDS ROW 2 — 4 CARDS --}}
<div class="flex flex-wrap -mx-3 mb-6">
    
    <!-- card5 - Average Score -->
    <div class="w-full max-w-full px-3 mb-6 sm:w-1/2 sm:flex-none xl:mb-0 xl:w-1/4">
        <div class="relative flex flex-col min-w-0 break-words bg-white shadow-soft-xl rounded-2xl bg-clip-border">
            <div class="flex-auto p-4">
                <div class="flex flex-row -mx-3">
                    <div class="flex-none w-2/3 max-w-full px-3">
                        <div>
                            <p class="mb-0 font-sans text-sm font-semibold leading-normal">Average Score</p>
                            <h5 class="mb-0 font-bold">
                                {{ $results->count() ? round($results->avg('total'), 1) : '—' }}
                                <span class="text-sm leading-normal font-weight-bolder text-red-500">avg</span>
                            </h5>
                        </div>
                    </div>
                    <div class="px-3 text-right basis-1/3">
                        <div class="inline-block w-12 h-12 text-center rounded-lg bg-gradient-to-tl from-red-500 to-rose-400">
                            <i class="fa fa-chart-bar text-lg relative top-3.5 text-black"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- card6 - Grade B -->
    <div class="w-full max-w-full px-3 mb-6 sm:w-1/2 sm:flex-none xl:mb-0 xl:w-1/4">
        <div class="relative flex flex-col min-w-0 break-words bg-white shadow-soft-xl rounded-2xl bg-clip-border">
            <div class="flex-auto p-4">
                <div class="flex flex-row -mx-3">
                    <div class="flex-none w-2/3 max-w-full px-3">
                        <div>
                            <p class="mb-0 font-sans text-sm font-semibold leading-normal">Grade B</p>
                            <h5 class="mb-0 font-bold">
                                {{ $results->where('grade', 'B')->count() }}
                                <span class="text-sm leading-normal font-weight-bolder text-teal-500">good</span>
                            </h5>
                        </div>
                    </div>
                    <div class="px-3 text-right basis-1/3">
                        <div class="inline-block w-12 h-12 text-center rounded-lg bg-gradient-to-tl from-teal-500 to-green-400">
                            <i class="fa fa-thumbs-up text-lg relative top-3.5 text-black"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- card7 - Grade C -->
    <div class="w-full max-w-full px-3 mb-6 sm:w-1/2 sm:flex-none xl:mb-0 xl:w-1/4">
        <div class="relative flex flex-col min-w-0 break-words bg-white shadow-soft-xl rounded-2xl bg-clip-border">
            <div class="flex-auto p-4">
                <div class="flex flex-row -mx-3">
                    <div class="flex-none w-2/3 max-w-full px-3">
                        <div>
                            <p class="mb-0 font-sans text-sm font-semibold leading-normal">Grade C</p>
                            <h5 class="mb-0 font-bold">
                                {{ $results->where('grade', 'C')->count() }}
                                <span class="text-sm leading-normal font-weight-bolder text-amber-500">average</span>
                            </h5>
                        </div>
                    </div>
                    <div class="px-3 text-right basis-1/3">
                        <div class="inline-block w-12 h-12 text-center rounded-lg bg-gradient-to-tl from-amber-500 to-orange-400">
                            <i class="fa fa-chart-simple text-lg relative top-3.5 text-black"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- card8 - Failing (Grade D/F) -->
    <div class="w-full max-w-full px-3 sm:w-1/2 sm:flex-none xl:w-1/4">
        <div class="relative flex flex-col min-w-0 break-words bg-white shadow-soft-xl rounded-2xl bg-clip-border">
            <div class="flex-auto p-4">
                <div class="flex flex-row -mx-3">
                    <div class="flex-none w-2/3 max-w-full px-3">
                        <div>
                            <p class="mb-0 font-sans text-sm font-semibold leading-normal">Failing</p>
                            <h5 class="mb-0 font-bold">
                                {{ $results->whereIn('grade', ['D', 'F'])->count() }}
                                <span class="text-sm leading-normal font-weight-bolder text-slate-500">needs improvement</span>
                            </h5>
                        </div>
                    </div>
                    <div class="px-3 text-right basis-1/3">
                        <div class="inline-block w-12 h-12 text-center rounded-lg bg-gradient-to-tl from-slate-600 to-slate-400">
                            <i class="fa fa-times-circle text-lg relative top-3.5 text-black"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

    {{-- RESULTS TABLE --}}
    <div class="bg-white rounded-2xl shadow-soft-xl overflow-hidden">

        {{-- Table Header --}}
        <div class="flex flex-wrap items-center justify-between px-6 py-4 border-b border-gray-100 gap-3">
            <div>
                <h6 class="font-bold text-slate-700">All Results</h6>
                <p class="text-xs text-slate-400 mt-0.5">
                    Total: <span class="font-semibold text-slate-600">{{ $results->count() }}</span> entries
                </p>
            </div>
            <div class="flex items-center gap-3">
                <div class="relative">
                    <i class="fa fa-search absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-xs"></i>
                    <input type="text"
                           id="searchInput"
                           placeholder="Search student or subject..."
                           onkeyup="filterTable()"
                           class="pl-8 pr-4 py-2 text-sm border border-gray-200 rounded-lg focus:outline-none focus:border-fuchsia-300 w-56" />
                </div>
            </div>
        </div>

        {{-- Table --}}
        <div class="overflow-x-auto" style="max-width: 100%; overflow-x: auto; -webkit-overflow-scrolling: touch;">
         <div style="min-width: 1200px;">
            <table class="items-center w-full mb-0 align-top border-gray-200 text-slate-500" id="resultsTable">
                <thead class="align-bottom bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xxs font-bold uppercase tracking-wider text-slate-400 opacity-70">#</th>
                        <th class="px-6 py-3 text-left text-xxs font-bold uppercase tracking-wider text-slate-400 opacity-70">Student</th>
                        <th class="px-6 py-3 text-left text-xxs font-bold uppercase tracking-wider text-slate-400 opacity-70">Subject</th>
                        <th class="px-6 py-3 text-center text-xxs font-bold uppercase tracking-wider text-slate-400 opacity-70">CA1</th>
                        <th class="px-6 py-3 text-center text-xxs font-bold uppercase tracking-wider text-slate-400 opacity-70">CA2</th>
                        <!-- <th class="px-6 py-3 text-center text-xxs font-bold uppercase tracking-wider text-slate-400 opacity-70">CA3</th> -->
                        <th class="px-6 py-3 text-center text-xxs font-bold uppercase tracking-wider text-slate-400 opacity-70">Exam</th>
                        <th class="px-6 py-3 text-center text-xxs font-bold uppercase tracking-wider text-slate-400 opacity-70">Total</th>
                        <th class="px-6 py-3 text-center text-xxs font-bold uppercase tracking-wider text-slate-400 opacity-70">Grade</th>
                        <th class="px-6 py-3 text-center text-xxs font-bold uppercase tracking-wider text-slate-400 opacity-70">Position</th>
                        <th class="px-6 py-3 text-center text-xxs font-bold uppercase tracking-wider text-slate-400 opacity-70">Status</th>
                        <th class="px-6 py-3 text-center text-xxs font-bold uppercase tracking-wider text-slate-400 opacity-70">Actions</th>
                    </tr>
                </thead>
                <tbody>

                    @forelse($results as $index => $result)
                    <tr class="border-t border-gray-100 hover:bg-gray-50 transition-colors">

                        {{-- # --}}
                        <td class="px-6 py-3 align-middle">
                            <span class="text-xs text-slate-400">{{ $index + 1 }}</span>
                        </td>

                        {{-- Student --}}
                        <td class="px-6 py-3 align-middle">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-xl bg-gradient-to-tl from-blue-500 to-cyan-400 flex items-center justify-center text-primary text-xs font-bold shadow-soft-md flex-shrink-0">
                                    {{ strtoupper(substr($result->student->name ?? 'N', 0, 2)) }}
                                </div>
                                <p class="text-sm font-semibold text-slate-700 mb-0">{{ $result->student->name ?? 'N/A' }}</p>
                            </div>
                        </td>

                        {{-- Subject --}}
                        <td class="px-6 py-3 align-middle">
                            <span class="text-xs font-semibold bg-blue-50 text-blue-600 px-2 py-1 rounded-lg">
                                {{ $result->subject->name ?? 'N/A' }}
                            </span>
                        </td>

                        {{-- CA1 --}}
                        <td class="px-6 py-3 align-middle text-center">
                            <span class="text-sm text-slate-600">{{ $result->ca1 ?? '—' }}</span>
                        </td>

                        {{-- CA2 --}}
                        <td class="px-6 py-3 align-middle text-center">
                            <span class="text-sm text-slate-600">{{ $result->ca2 ?? '—' }}</span>
                        </td>

                        {{-- CA3 --}}
                        <!-- <td class="px-6 py-3 align-middle text-center">
                            <span class="text-sm text-slate-600">{{ $result->ca3 ?? '—' }}</span>
                        </td> -->

                        {{-- Exam --}}
                        <td class="px-6 py-3 align-middle text-center">
                            <span class="text-sm text-slate-600">{{ $result->exam ?? '—' }}</span>
                        </td>

                        {{-- Total --}}
                        <td class="px-6 py-3 align-middle text-center">
                            <span class="text-sm font-bold text-slate-700">{{ $result->total ?? '—' }}</span>
                        </td>

                        {{-- Grade --}}
                        <td class="px-6 py-3 align-middle text-center">
                            @php
                                $gradeColors = [
                                    'A' => 'bg-green-50 text-green-600',
                                    'B' => 'bg-blue-50 text-blue-600',
                                    'C' => 'bg-cyan-50 text-cyan-600',
                                    'D' => 'bg-orange-50 text-orange-500',
                                    'E' => 'bg-yellow-50 text-yellow-600',
                                    'F' => 'bg-red-50 text-red-600',
                                ];
                                $gc = $gradeColors[$result->grade ?? ''] ?? 'bg-gray-100 text-gray-500';
                            @endphp
                            @if($result->grade)
                                <span class="text-xs font-bold {{ $gc }} px-2 py-1 rounded-lg">
                                    {{ $result->grade }}
                                </span>
                            @else
                                <span class="text-xs text-slate-300">—</span>
                            @endif
                        </td>

                        {{-- Position --}}
                        <td class="px-6 py-3 align-middle text-center">
                            @if($result->position == 1)
                                <span class="text-xs font-bold text-yellow-500">🥇 1st</span>
                            @elseif($result->position == 2)
                                <span class="text-xs font-bold text-slate-400">🥈 2nd</span>
                            @elseif($result->position == 3)
                                <span class="text-xs font-bold text-amber-600">🥉 3rd</span>
                            @elseif($result->position)
                                <span class="text-xs text-slate-500">{{ $result->position }}th</span>
                            @else
                                <span class="text-xs text-slate-300">—</span>
                            @endif
                        </td>

                        {{-- Submitted Status --}}
                        <td class="px-6 py-3 align-middle text-center">
                            @if($result->submitted)
                                <span class="text-xs font-semibold bg-green-50 text-green-600 px-3 py-1 rounded-full">
                                    <i class="fa fa-lock mr-1 text-xs"></i> Submitted
                                </span>
                            @else
                                <span class="text-xs font-semibold bg-orange-50 text-orange-500 px-3 py-1 rounded-full">
                                    <i class="fa fa-pen mr-1 text-xs"></i> Draft
                                </span>
                            @endif
                        </td>

                        {{-- Actions --}}
                        <td class="px-6 py-3 align-middle text-center">
                            <div class="flex items-center justify-center gap-2">
                                @if(!$result->submitted)
                                    <a href="{{ route('tenant.teacher.results.edit', [$subdomain, $result->student_id]) }}?subject_id={{ $result->subject_id }}&term={{ urlencode($result->term) }}&session={{ urlencode($result->session) }}"
                                       class="w-7 h-7 rounded-lg bg-amber-50 text-amber-500 flex items-center justify-center hover:bg-amber-100 transition-colors"
                                       title="Edit">
                                        <i class="fa fa-pen text-xs"></i>
                                    </a>
                                @else
                                    <span class="w-7 h-7 rounded-lg bg-gray-50 text-gray-300 flex items-center justify-center cursor-not-allowed" title="Locked">
                                        <i class="fa fa-lock text-xs"></i>
                                    </span>
                                @endif
                            </div>
                        </td>

                    </tr>
                    @empty
                    <tr>
                        <td colspan="12" class="px-6 py-12 text-center">
                            <div class="flex flex-col items-center">
                                <div class="w-16 h-16 rounded-2xl bg-gray-100 flex items-center justify-center mb-4">
                                    <i class="fa fa-star text-gray-400 text-2xl"></i>
                                </div>
                                <p class="text-slate-500 font-semibold">No results found</p>
                                <p class="text-slate-400 text-sm mt-1">Use Bulk Entry or Single Entry to add results</p>
                                <div class="flex gap-3 mt-4">
                                    <a href="{{ route('tenant.teacher.results.bulk', $subdomain) }}"
                                       class="px-4 py-2 text-sm text-white rounded-lg bg-gradient-to-tl from-blue-600 to-cyan-400">
                                        Bulk Entry
                                    </a>
                                    <a href="{{ route('tenant.teacher.results.create', $subdomain) }}"
                                       class="px-4 py-2 text-sm text-white rounded-lg bg-gradient-to-tl from-gray-900 to-slate-700">
                                        Single Entry
                                    </a>
                                </div>
                            </div>
                        </td>
                    </tr>
                    @endforelse

                </tbody>
            </table>
        </div>
        </div>

        {{-- Footer --}}
        <div class="flex items-center justify-between px-6 py-4 border-t border-gray-100">
            <p class="text-xs text-slate-400">
                Total: <span class="font-semibold text-slate-600">{{ $results->count() }}</span> results
            </p>
        </div>

    </div>

</div>

<script>
function filterTable() {
    const input = document.getElementById('searchInput').value.toLowerCase();
    const rows = document.querySelectorAll('#resultsTable tbody tr');
    rows.forEach(row => {
        row.style.display = row.innerText.toLowerCase().includes(input) ? '' : 'none';
    });
}
</script>

@endsection