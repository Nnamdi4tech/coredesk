@extends('layouts.admin')

@section('content')

@php $subdomain = request()->route('subdomain'); @endphp

<div class="w-full px-6 py-6 mx-auto">

    {{-- PAGE HEADER --}}
    <div class="flex flex-wrap items-center justify-between mb-6 -mx-3">
        <div class="px-3">
            <h3 class="text-2xl font-bold text-slate-700 mb-1">Results for {{ $subject->name ?? 'Subject' }}</h3>
            <p class="text-sm text-slate-400">
                <i class="fa fa-home mr-1"></i> Dashboard
                <span class="mx-1 text-slate-300">/</span>
                <a href="{{ route('tenant.admin.results.index', $subdomain) }}" class="hover:text-slate-600">Results Review</a>
                <span class="mx-1 text-slate-300">/</span>
                <span class="text-slate-600">{{ $subject->name ?? 'Subject' }}</span>
            </p>
        </div>
        <div class="px-3 mt-3 md:mt-0">
            <a href="{{ route('tenant.admin.results.index', $subdomain) }}"
               class="px-4 py-2 text-sm border border-gray-300 rounded-lg text-slate-600 hover:bg-gray-50 transition-all">
                <i class="fa fa-arrow-left mr-1"></i> Back to Results
            </a>
        </div>
    </div>

    {{-- SUCCESS / ERROR MESSAGES --}}
    @if(session('success'))
        <div class="p-4 mb-6 text-sm text-green-700 bg-green-50 border border-green-200 rounded-2xl flex items-center gap-3">
            <div class="w-8 h-8 rounded-lg bg-gradient-to-tl from-green-500 to-emerald-400 flex items-center justify-center flex-shrink-0">
                <i class="fa fa-check text-white text-xs"></i>
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
                <i class="fa fa-exclamation-circle text-white text-xs"></i>
            </div>
            <p class="font-semibold">{{ session('error') }}</p>
            <button onclick="this.parentElement.remove()" class="ml-auto text-red-400 hover:text-red-600">
                <i class="fa fa-times text-xs"></i>
            </button>
        </div>
    @endif

    {{-- RESULTS TABLE CARD --}}
    <div class="bg-white shadow-soft-xl rounded-2xl overflow-hidden">
        
        <div class="flex flex-wrap items-center justify-between px-6 py-4 border-b border-gray-100 gap-3">
            <div>
                <h6 class="font-bold text-slate-700">
                    Student Results
                </h6>
                <p class="text-xs text-slate-400 mt-0.5">
                    {{ $results->count() }} {{ Str::plural('student', $results->count()) }} in Class {{ $classId }}
                </p>
            </div>
            <div class="flex gap-2">
                <span class="px-3 py-1 text-xs font-semibold rounded-full bg-blue-50 text-blue-600">
                    <i class="fa fa-chalkboard-user mr-1"></i> Class ID: {{ $classId }}
                </span>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="items-center w-full mb-0 align-top border-gray-200 text-slate-500">
                <thead class="align-bottom bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xxs font-bold uppercase tracking-wider text-slate-400 opacity-70">Student</th>
                        <th class="px-6 py-3 text-center text-xxs font-bold uppercase tracking-wider text-slate-400 opacity-70">CA1 <span class="text-slate-300">/20</span></th>
                        <th class="px-6 py-3 text-center text-xxs font-bold uppercase tracking-wider text-slate-400 opacity-70">CA2 <span class="text-slate-300">/20</span></th>
                        <!-- <th class="px-6 py-3 text-center text-xxs font-bold uppercase tracking-wider text-slate-400 opacity-70">CA3 <span class="text-slate-300">/40</span></th> -->
                        <th class="px-6 py-3 text-center text-xxs font-bold uppercase tracking-wider text-slate-400 opacity-70">Exam <span class="text-slate-300">/60</span></th>
                        <th class="px-6 py-3 text-center text-xxs font-bold uppercase tracking-wider text-slate-400 opacity-70">Total</th>
                        <th class="px-6 py-3 text-center text-xxs font-bold uppercase tracking-wider text-slate-400 opacity-70">Average</th>
                        <th class="px-6 py-3 text-center text-xxs font-bold uppercase tracking-wider text-slate-400 opacity-70">Grade</th>
                        <th class="px-6 py-3 text-center text-xxs font-bold uppercase tracking-wider text-slate-400 opacity-70">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($results as $result)
                    @php
                        $total = $result->ca1 + $result->ca2  + $result->exam;
                        $average = $total / 2; // Since total is out of 100, average out of 50
                        $grade = $total >= 70 ? 'A' : ($total >= 60 ? 'B' : ($total >= 50 ? 'C' : ($total >= 45 ? 'D' : 'F')));
                        $remark = $total >= 70 ? 'Excellent' : ($total >= 60 ? 'Good' : ($total >= 50 ? 'Fair' : ($total >= 45 ? 'Pass' : 'Fail')));
                    @endphp
                    <tr class="border-t border-gray-100 hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4 align-middle">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-xl bg-gradient-to-tl from-blue-500 to-cyan-400 flex items-center justify-center text-black text-xs font-bold shadow-soft-md flex-shrink-0">
                                    {{ strtoupper(substr($result->student->name ?? 'N/A', 0, 2)) }}
                                </div>
                                <div>
                                    <p class="text-sm font-semibold text-slate-700 mb-0">{{ $result->student->name ?? 'N/A' }}</p>
                                    <p class="text-xs text-slate-400">{{ $result->student->student_id ?? 'N/A' }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 align-middle text-center text-sm">{{ $result->ca1 }}</td>
                        <td class="px-6 py-4 align-middle text-center text-sm">{{ $result->ca2 }}</td>
                        <!-- <td class="px-6 py-4 align-middle text-center text-sm">{{ $result->ca3 }}</td> -->
                        <td class="px-6 py-4 align-middle text-center text-sm">{{ $result->exam }}</td>
                        <td class="px-6 py-4 align-middle text-center text-sm font-semibold">{{ $total }}</td>
                        <td class="px-6 py-4 align-middle text-center text-sm">{{ number_format($average, 2) }}</td>
                        <td class="px-6 py-4 align-middle text-center">
                            <span class="inline-flex items-center gap-1.5 text-xs font-semibold 
                                {{ $grade == 'A' ? 'bg-green-50 text-green-600' : 
                                   ($grade == 'B' ? 'bg-blue-50 text-blue-600' : 
                                   ($grade == 'C' ? 'bg-yellow-50 text-yellow-600' : 
                                   ($grade == 'D' ? 'bg-orange-50 text-orange-600' : 'bg-red-50 text-red-600'))) }} 
                                px-2.5 py-1 rounded-full">
                                {{ $grade }}
                            </span>
                        </td>
                        <td class="px-6 py-4 align-middle text-center">
    <div class="flex items-center justify-center gap-2">

        @if($result->approved)
            <span class="inline-flex items-center gap-1 px-3 py-1.5 text-xs font-semibold text-green-600 bg-green-50 rounded-lg">
                <i class="fa fa-lock text-xs"></i> Approved
            </span>

        @elseif($result->rejected)
            <span class="inline-flex items-center gap-1 px-3 py-1.5 text-xs font-semibold text-red-500 bg-red-50 rounded-lg">
                <i class="fa fa-times-circle text-xs"></i> Rejected
            </span>

        @else
            {{-- Approve One --}}
            <form method="POST"
                action="{{ route('tenant.admin.results.approve.one', [$subdomain, $result->id]) }}"
                style="display:inline;">
                @csrf
                <button type="submit"
                        onclick="return confirm('Approve this student\'s result?')"
                        class="inline-flex items-center gap-1 px-3 py-1.5 text-xs font-semibold text-white rounded-lg bg-gradient-to-tl from-green-600 to-emerald-500 hover:scale-105 transition-all">
                    <i class="fa fa-check-circle text-xs"></i> Approve
                </button>
            </form>

            {{-- Reject One --}}
            <form method="POST"
                action="{{ route('tenant.admin.results.reject.one', [$subdomain, $result->id]) }}"
                style="display:inline;">
                @csrf
                <button type="submit"
                        onclick="return confirm('Reject this student\'s result? This will unlock it for editing.')"
                        class="inline-flex items-center gap-1 px-3 py-1.5 text-xs font-semibold text-white rounded-lg bg-gradient-to-tl from-red-600 to-rose-500 hover:scale-105 transition-all">
                    <i class="fa fa-times-circle text-xs"></i> Reject
                </button>
            </form>
        @endif

    </div>
</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- Bulk Actions --}}
<div class="flex items-center justify-between px-6 py-4 border-t border-gray-100">
    <p class="text-xs text-slate-400">
        <i class="fa fa-info-circle mr-1"></i>
        Approve all to lock results permanently. Reject all to unlock for teacher editing.
    </p>
    <div class="flex gap-3">
        @if($results->where('approved', false)->where('submitted', true)->count() > 0)
        <form action="{{ route('tenant.admin.results.approve', [$subdomain, $subject->id, $classId]) }}"
              method="POST" style="display: inline-block;">
            @csrf
            <button type="submit"
                    onclick="return confirm('⚠️ Approve ALL results for {{ $subject->name }}? This will lock them permanently.')"
                    class="px-5 py-2 text-sm font-semibold text-white rounded-lg bg-gradient-to-tl from-green-600 to-emerald-500 shadow-soft-md hover:shadow-soft-xl hover:scale-105 transition-all">
                <i class="fa fa-check-circle mr-1"></i> Approve All
            </button>
        </form>

        <form action="{{ route('tenant.admin.results.reject', [$subdomain, $subject->id, $classId]) }}"
              method="POST" style="display: inline-block;">
            @csrf
            <button type="submit"
                    onclick="return confirm('⚠️ Reject ALL results for {{ $subject->name }}? This will unlock them for teacher editing.')"
                    class="px-5 py-2 text-sm font-semibold text-white rounded-lg bg-gradient-to-tl from-red-600 to-rose-500 shadow-soft-md hover:shadow-soft-xl hover:scale-105 transition-all">
                <i class="fa fa-times-circle mr-1"></i> Reject All
            </button>
        </form>
        @else
            <span class="px-4 py-2 text-xs font-semibold text-green-600 bg-green-50 rounded-lg">
                <i class="fa fa-lock mr-1"></i> All results approved and locked
            </span>
        @endif
    </div>
</div>

    </div>

</div>

@endsection