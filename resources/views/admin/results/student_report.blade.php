@extends('layouts.admin')

@section('content')

@php $subdomain = request()->route('subdomain'); @endphp

<div class="w-full px-6 py-6 mx-auto">

    {{-- PAGE HEADER --}}
    <div class="flex flex-wrap items-center justify-between mb-6 -mx-3">
        <div class="px-3">
            <h3 class="text-2xl font-bold text-slate-700 mb-1">Student Report Card</h3>
            <p class="text-sm text-slate-400">
                <i class="fa fa-home mr-1"></i> Dashboard
                <span class="mx-1 text-slate-300">/</span>
                <a href="{{ route('tenant.admin.results.filter', $subdomain) }}" class="hover:text-slate-600">Report Cards</a>
                <span class="mx-1 text-slate-300">/</span>
                <span class="text-slate-600">{{ $student->name }}</span>
            </p>
        </div>
        <div class="px-3 mt-3 md:mt-0 flex gap-2">
            <button onclick="window.history.back()"
                    class="px-4 py-2 text-sm font-semibold text-slate-600 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 hover:border-gray-400 transition-all">
                <i class="fa fa-arrow-left mr-1"></i> Go Back
            </button>
            <button onclick="window.print()"
                    class="px-4 py-2 text-sm font-semibold text-black rounded-lg bg-gradient-to-tl from-green-600 to-emerald-500 shadow-soft-md hover:shadow-soft-xl hover:scale-105 transition-all">
                <i class="fa fa-print mr-1"></i> Print Report Card
            </button>
        </div>
    </div>

    {{-- REPORT CARD --}}
    <div id="printArea" class="bg-white shadow-soft-xl rounded-2xl overflow-hidden">

        {{-- Card Header --}}
        <div class="bg-gradient-to-r px-6 py-4">
            <h2 class="text-2xl font-bold text-black text-center mb-1">STUDENT REPORT CARD</h2>
            <p class="text-center text-black text-xs">Academic Performance Summary</p>
        </div>

        {{-- Info Section --}}
        <div class="flex flex-wrap justify-between gap-4 px-6 py-5 border-b border-gray-100 bg-gray-50">
            <div>
                <div class="flex items-center gap-2 mb-2">
                    <div class="w-8 h-8 rounded-lg bg-gradient-to-tl from-purple-500 to-pink-400 flex items-center justify-center shadow-soft-sm">
                        <i class="fa fa-user-graduate text-black text-xs"></i>
                    </div>
                    <span class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Student Information</span>
                </div>
                <p class="text-sm text-slate-700 mb-1">
                    <strong class="font-semibold">Name:</strong> {{ $student->name }}
                </p>
                <p class="text-sm text-slate-700">
                    <strong class="font-semibold">Class:</strong> {{ $student->schoolClass->name ?? $student->class ?? 'N/A' }}
                </p>
            </div>

            <div>
                <div class="flex items-center gap-2 mb-2">
                    <div class="w-8 h-8 rounded-lg bg-gradient-to-tl from-blue-500 to-cyan-400 flex items-center justify-center shadow-soft-sm">
                        <i class="fa fa-calendar-alt text-black text-xs"></i>
                    </div>
                    <span class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Academic Details</span>
                </div>
                <p class="text-sm text-slate-700 mb-1">
                    <strong class="font-semibold">Term:</strong> {{ $term }}
                </p>
                <p class="text-sm text-slate-700">
                    <strong class="font-semibold">Session:</strong> {{ $session }}
                </p>
            </div>

            <div>
                <div class="flex items-center gap-2 mb-2">
                    <div class="w-8 h-8 rounded-lg bg-gradient-to-tl from-green-500 to-emerald-400 flex items-center justify-center shadow-soft-sm">
                        <i class="fa fa-trophy text-black text-xs"></i>
                    </div>
                    <span class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Overall Standing</span>
                </div>
                <p class="text-sm text-slate-700 mb-1">
                    <strong class="font-semibold">Total Score:</strong> {{ $overallTotal }}
                </p>
                <p class="text-sm text-slate-700 mb-1">
                    <strong class="font-semibold">Average:</strong> {{ number_format($overallAverage, 2) }}
                </p>
                <p class="text-sm text-slate-700">
                    <strong class="font-semibold">Overall Position:</strong>
                    <span class="inline-flex items-center justify-center w-7 h-7 text-sm font-bold rounded-full bg-amber-50 text-amber-500 ml-1">
                        {{ $overallPosition }}
                    </span>
                </p>
            </div>
        </div>

        {{-- Results Table --}}
        <div class="overflow-x-auto">
            <table class="items-center w-full mb-0 align-top border-gray-200 text-slate-500">
                <thead class="align-bottom bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xxs font-bold uppercase tracking-wider text-slate-400 opacity-70">Subject</th>
                        <th class="px-6 py-3 text-center text-xxs font-bold uppercase tracking-wider text-slate-400 opacity-70">CA1 <span class="text-slate-300 normal-case font-normal">/20</span></th>
                        <th class="px-6 py-3 text-center text-xxs font-bold uppercase tracking-wider text-slate-400 opacity-70">CA2 <span class="text-slate-300 normal-case font-normal">/20</span></th>
                        <th class="px-6 py-3 text-center text-xxs font-bold uppercase tracking-wider text-slate-400 opacity-70">Exam <span class="text-slate-300 normal-case font-normal">/60</span></th>
                        <th class="px-6 py-3 text-center text-xxs font-bold uppercase tracking-wider text-slate-400 opacity-70">Total</th>
                        <th class="px-6 py-3 text-center text-xxs font-bold uppercase tracking-wider text-slate-400 opacity-70">Grade</th>
                        <th class="px-6 py-3 text-center text-xxs font-bold uppercase tracking-wider text-slate-400 opacity-70">Position</th>
                        @if($term === 'Third Term')
                        <th class="px-6 py-3 text-center text-xxs font-bold uppercase tracking-wider text-slate-400 opacity-70">
                         3-Term Avg
                         </th>
                        @endif
                         
                        <th class="px-6 py-3 text-left text-xxs font-bold uppercase tracking-wider text-slate-400 opacity-70">Remark</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($results as $res)
                    @php
                        $grade = $res->grade;
                    @endphp
                    <tr class="border-t border-gray-100 hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4 align-middle">
                            <div class="flex items-center gap-3">
                                <div class="w-7 h-7 rounded-lg bg-gradient-to-tl from-blue-500 to-cyan-400 flex items-center justify-center text-black text-xs font-bold shadow-soft-sm flex-shrink-0">
                                    <i class="fa fa-book text-xs"></i>
                                </div>
                                <p class="text-sm font-semibold text-slate-700 mb-0">{{ $res->subject->name }}</p>
                            </div>
                        </td>
                        <td class="px-6 py-4 align-middle text-center text-sm">{{ $res->ca1 }}</td>
                        <td class="px-6 py-4 align-middle text-center text-sm">{{ $res->ca2 }}</td>
                        <td class="px-6 py-4 align-middle text-center text-sm">{{ $res->exam }}</td>
                        <td class="px-6 py-4 align-middle text-center text-sm font-bold text-slate-700">
                            <span class="{{ $res->total >= 70 ? 'text-green-600' : ($res->total >= 50 ? 'text-blue-600' : ($res->total >= 40 ? 'text-orange-600' : 'text-red-600')) }}">
                                {{ $res->total }}
                            </span>
                        </td>
                        <td class="px-6 py-4 align-middle text-center">
                            <span class="inline-flex items-center gap-1.5 text-xs font-semibold px-2.5 py-1 rounded-full
                                {{ $grade == 'A' ? 'bg-green-50 text-green-600' :
                                   ($grade == 'B' ? 'bg-blue-50 text-blue-600' :
                                   ($grade == 'C' ? 'bg-yellow-50 text-yellow-600' :
                                   ($grade == 'D' ? 'bg-orange-50 text-orange-600' : 'bg-red-50 text-red-600'))) }}">
                                {{ $grade }}
                            </span>
                        </td>
                        <td class="px-6 py-4 align-middle text-center">
                            <span class="inline-flex items-center justify-center w-8 h-8 text-sm font-bold rounded-full bg-gray-100 text-slate-500">
                                {{ $res->position }}
                            </span>
                        </td>
                        @if($term === 'Third Term')
<td class="px-6 py-4 align-middle">

    @php $cum = $cumulativeData[$res->subject_id] ?? null; @endphp

    @if($cum)
        <table class="w-full text-xs text-slate-600 border border-gray-100 rounded-lg overflow-hidden">

            <tr class="border-b">
                <td class="px-2 py-1 font-semibold bg-gray-50">T1</td>
                <td class="px-2 py-1 text-right">{{ $cum['t1'] ?? '-' }}</td>
            </tr>

            <tr class="border-b">
                <td class="px-2 py-1 font-semibold bg-gray-50">T2</td>
                <td class="px-2 py-1 text-right">{{ $cum['t2'] ?? '-' }}</td>
            </tr>

            <tr class="border-b">
                <td class="px-2 py-1 font-semibold bg-gray-50">T3</td>
                <td class="px-2 py-1 text-right">{{ $cum['t3'] ?? '-' }}</td>
            </tr>

            <tr>
                <td class="px-2 py-1 font-bold bg-gray-100">Avg</td>
                <td class="px-2 py-1 text-right font-bold
                    {{ $cum['grade'] == 'A' ? 'text-green-600' :
                       ($cum['grade'] == 'B' ? 'text-blue-600' :
                       ($cum['grade'] == 'C' ? 'text-yellow-600' :
                       ($cum['grade'] == 'D' ? 'text-orange-600' : 'text-red-600'))) }}">
                    
                    {{ $cum['avg'] }} ({{ $cum['grade'] }})
                </td>
            </tr>

        </table>
    @else
        <span class="text-slate-300">-</span>
    @endif

</td>
@endif
                        
                        <td class="px-6 py-4 align-middle text-sm text-slate-500">{{ $res->remark }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- Summary Stats --}}
        <div class="flex flex-wrap -mx-3 mt-5 px-4 py-4 bg-gray-50 border-t border-gray-200">
            <div class="w-full max-w-full px-3 mb-4 sm:w-1/2 sm:flex-none xl:mb-0 xl:w-1/3">
                <div class="relative flex flex-col min-w-0 break-words bg-white shadow-soft-sm rounded-xl bg-clip-border">
                    <div class="flex-auto p-3">
                        <div class="flex flex-row -mx-3">
                            <div class="flex-none w-2/3 max-w-full px-3">
                                <p class="mb-0 font-sans text-xs font-semibold leading-normal text-slate-500">Total Score</p>
                                <h5 class="mb-0 font-bold text-slate-700 text-lg">{{ $term === 'Third Term' ? round($cumulativeOverallTotal) : $overallTotal }}</h5>
                            </div>
                            <div class="px-3 text-right basis-1/3">
                                <div class="inline-block w-10 h-10 text-center rounded-lg bg-gradient-to-tl from-blue-500 to-cyan-400">
                                    <i class="fa fa-calculator text-md relative top-2.5 text-black"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="w-full max-w-full px-3 mb-4 sm:w-1/2 sm:flex-none xl:mb-0 xl:w-1/3">
                <div class="relative flex flex-col min-w-0 break-words bg-white shadow-soft-sm rounded-xl bg-clip-border">
                    <div class="flex-auto p-3">
                        <div class="flex flex-row -mx-3">
                            <div class="flex-none w-2/3 max-w-full px-3">
                                <p class="mb-0 font-sans text-xs font-semibold leading-normal text-slate-500">Average Score</p>
                                <h5 class="mb-0 font-bold text-slate-700 text-lg">{{ $term === 'Third Term' 
    ? number_format($cumulativeOverallAverage, 2) 
    : number_format($overallAverage, 2) }}</h5>
                            </div>
                            <div class="px-3 text-right basis-1/3">
                                <div class="inline-block w-10 h-10 text-center rounded-lg bg-gradient-to-tl from-purple-500 to-pink-400">
                                    <i class="fa fa-chart-line text-md relative top-2.5 text-black"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="w-full max-w-full px-3 mb-4 sm:w-1/2 sm:flex-none xl:mb-0 xl:w-1/3">
                <div class="relative flex flex-col min-w-0 break-words bg-white shadow-soft-sm rounded-xl bg-clip-border">
                    <div class="flex-auto p-3">
                        <div class="flex flex-row -mx-3">
                            <div class="flex-none w-2/3 max-w-full px-3">
                                <p class="mb-0 font-sans text-xs font-semibold leading-normal text-slate-500">Overall Position</p>
                                <h5 class="mb-0 font-bold text-amber-500 text-lg">{{ $overallPosition }}</h5>
                            </div>
                            <div class="px-3 text-right basis-1/3">
                                <div class="inline-block w-10 h-10 text-center rounded-lg bg-gradient-to-tl from-amber-500 to-yellow-400">
                                    <i class="fa fa-trophy text-md relative top-2.5 text-black"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Overall Remark + Signatures --}}
        <div class="px-6 py-5 border-t border-gray-100">
            <div class="flex flex-wrap justify-between gap-6">
                <div>
                    <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1">Overall Remark</p>
                    <span class="inline-flex items-center px-3 py-1.5 text-sm font-semibold rounded-lg bg-blue-50 text-blue-700">
                        {{ $overallRemark ?? 'N/A' }}
                    </span>
                </div>
                <div>
                    <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Class Teacher Comment</p>
                    <div class="w-48 border-b-2 border-slate-300"></div>
                </div>
                <div>
                    <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Principal Signature</p>
                    <div class="w-48 border-b-2 border-slate-300"></div>
                </div>
            </div>
        </div>

        {{-- Footer --}}
        <div class="px-6 py-3 bg-gray-50 border-t border-gray-100 text-center">
            <p class="text-xs text-slate-400">
                <i class="fa fa-check-circle text-green-500 mr-1"></i>
                This is a computer-generated document. For verification, please contact the administration.
            </p>
        </div>

    </div>

</div>


{{-- Print Styles --}}
<script>
// Direct override of window.print
window.print = function() {
    // Store original body content
    const originalBody = document.body.innerHTML;
    const printArea = document.getElementById('printArea').cloneNode(true);
    
    // Create print window content
    const printContent = `
        <!DOCTYPE html>
        <html>
        <head>
            <title>Student Report Card</title>
            <style>
                body {
                    font-family: Arial, sans-serif;
                    margin: 20px;
                    padding: 20px;
                }
                table {
                    width: 100%;
                    border-collapse: collapse;
                    margin-bottom: 20px;
                }
                th, td {
                    border: 1px solid #ddd;
                    padding: 8px;
                    text-align: left;
                }
                th {
                    background-color: #f5f5f5;
                }
                .text-center {
                    text-align: center;
                }
                .text-right {
                    text-align: right;
                }
                .bg-gray-50 {
                    background-color: #f9fafb;
                }
                .border-t {
                    border-top: 1px solid #e5e7eb;
                }
                .border-b {
                    border-bottom: 1px solid #e5e7eb;
                }
                
                /* FIX: Make summary stats display horizontally */
                .flex-wrap {
                    display: flex !important;
                    flex-wrap: nowrap !important;
                    gap: 1rem !important;
                    margin-bottom: 1rem !important;
                }
                
                .flex-wrap > div {
                    flex: 1 !important;
                    min-width: 0 !important;
                }
                
                .flex {
                    display: flex;
                }
                
                .flex-row {
                    display: flex;
                    flex-direction: row;
                    align-items: center;
                    justify-content: space-between;
                }
                
                .justify-between {
                    justify-content: space-between;
                }
                
                .gap-4 {
                    gap: 1rem;
                }
                
                /* Reduce padding and margins */
                .px-6 {
                    padding-left: 1rem;
                    padding-right: 1rem;
                }
                
                .py-5 {
                    padding-top: 0.75rem;
                    padding-bottom: 0.75rem;
                }
                
                .py-4 {
                    padding-top: 0.5rem;
                    padding-bottom: 0.5rem;
                }
                
                .px-4 {
                    padding-left: 0.75rem;
                    padding-right: 0.75rem;
                }
                
                .mt-5 {
                    margin-top: 0.75rem;
                }
                
                .mb-4 {
                    margin-bottom: 0;
                }
                
                /* Make cards more compact */
                .shadow-soft-sm {
                    box-shadow: none;
                    border: 1px solid #e5e7eb;
                }
                
                .rounded-xl {
                    border-radius: 0.5rem;
                }
                
                .p-3 {
                    padding: 0.5rem !important;
                }
                
                .font-bold {
                    font-weight: bold;
                }
                
                .text-lg {
                    font-size: 1rem;
                }
                
                .text-xs {
                    font-size: 0.7rem;
                }
                
                .text-sm {
                    font-size: 0.8rem;
                }
                
                .rounded-xl {
                    border-radius: 0.75rem;
                }
                
                .bg-white {
                    background-color: white;
                }
                
                .border {
                    border: 1px solid #e5e7eb;
                }
                
                .w-full {
                    width: 100%;
                }
                
                .inline-block {
                    display: inline-block;
                }
                
                .text-slate-500 {
                    color: #64748b;
                }
                
                .text-slate-700 {
                    color: #334155;
                }
                
                .text-amber-500 {
                    color: #f59e0b;
                }
                
                .text-blue-700 {
                    color: #1d4ed8;
                }
                
                .bg-blue-50 {
                    background-color: #eff6ff;
                }
                
                .rounded-lg {
                    border-radius: 0.5rem;
                }
                
                .w-48 {
                    width: 12rem;
                }
                
                .border-b-2 {
                    border-bottom-width: 2px;
                }
                
                .border-slate-300 {
                    border-color: #cbd5e1;
                }
                
                /* Make the icon circles smaller */
                .w-10, .h-10 {
                    width: 2rem !important;
                    height: 2rem !important;
                }
                
                .relative {
                    position: relative;
                }
                
                .top-2\\.5 {
                    top: 0.6rem;
                }
                
                /* Reduce gap in remark section */
                .gap-6 {
                    gap: 1rem;
                }
                
                /* REMOVE THE VERTICAL LINE/ICON NEXT TO SUBJECT NAMES */
                td .flex.items-center.gap-3 > div:first-child,
                td .w-7.h-7,
                td .rounded-lg.bg-gradient-to-tl,
                .fa-book {
                    display: none !important;
                }
                
                /* Remove the gap and adjust subject name */
                td .flex.items-center.gap-3 {
                    gap: 0 !important;
                }
                
                td .text-sm.font-semibold {
                    margin-left: 0 !important;
                    padding-left: 0 !important;
                }
                
                @page {
                    size: portrait;
                    margin: 1cm;
                }
                
                @media print {
                    body {
                        margin: 0;
                        padding: 0;
                    }
                    
                    /* Ensure everything fits on one page if possible */
                    .flex-wrap {
                        page-break-inside: avoid;
                    }
                }
            </style>
        </head>
        <body>
            ${printArea.outerHTML}
        </body>
        </html>
    `;
    
    // Open print window
    const printWindow = window.open('', '_blank');
    printWindow.document.write(printContent);
    printWindow.document.close();
    printWindow.print();
    printWindow.close();
};

// Ensure the original print button calls our new function
document.addEventListener('DOMContentLoaded', function() {
    const printBtn = document.querySelector('button[onclick="window.print()"]');
    if (printBtn) {
        printBtn.removeAttribute('onclick');
        printBtn.addEventListener('click', function(e) {
            e.preventDefault();
            window.print();
        });
    }
});
</script>

@endsection