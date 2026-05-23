@extends('layouts.admin')

@section('content')

@php $subdomain = request()->route('subdomain'); @endphp

<div class="w-full px-6 py-6 mx-auto">

    {{-- Success / Error Messages --}}
    @if(session('success'))
        <div id="successMsg" class="flex items-center gap-3 px-4 py-3 mb-6 text-sm font-semibold text-green-800 bg-green-50 border border-green-200 rounded-xl">
            <div class="w-7 h-7 rounded-lg bg-gradient-to-tl from-green-500 to-emerald-400 flex items-center justify-center flex-shrink-0">
                <i class="fa fa-check text-black text-xs"></i>
            </div>
            {{ session('success') }}
            <button onclick="this.parentElement.remove()" class="ml-auto text-green-500 hover:text-green-700">
                <i class="fa fa-times text-black text-xs"></i>
            </button>
        </div>
    @endif

    @if(session('error'))
        <div class="flex items-center gap-3 px-4 py-3 mb-6 text-sm font-semibold text-red-800 bg-red-50 border border-red-200 rounded-xl">
            <div class="w-7 h-7 rounded-lg bg-gradient-to-tl from-red-500 to-rose-400 flex items-center justify-center flex-shrink-0">
                <i class="fa fa-exclamation-circle text-black text-xs"></i>
            </div>
            {{ session('error') }}
            <button onclick="this.parentElement.remove()" class="ml-auto text-red-500 hover:text-red-700">
                <i class="fa fa-times text-black text-xs"></i>
            </button>
        </div>
    @endif

    {{-- PAGE HEADER --}}
    <div class="flex flex-wrap items-center justify-between mb-6 -mx-3">
        <div class="px-3">
            <h3 class="text-2xl font-bold text-slate-700 mb-1">Examination Schedule</h3>
            <p class="text-sm text-slate-400">
                <i class="fa fa-home mr-1"></i> Dashboard
                <span class="mx-1 text-slate-300">/</span>
                <span class="text-slate-600">Exam Management</span>
            </p>
        </div>
        
        <div class="px-3 mt-3 md:mt-0 flex gap-2">
            <button onclick="printExamSchedule()"
                class="px-4 py-2 text-sm font-semibold text-white rounded-lg bg-gradient-to-tl from-blue-600 to-cyan-500 shadow-soft-md hover:shadow-soft-xl hover:scale-105 transition-all">
                <i class="fa fa-print mr-1"></i> Print Exam Schedule
            </button>
            <a href="{{ route('tenant.exam.create', $subdomain) }}"
               class="px-4 py-2 text-sm font-semibold text-white rounded-lg bg-gradient-to-tl from-green-600 to-emerald-500 shadow-soft-md hover:shadow-soft-xl hover:scale-105 transition-all">
                <i class="fa fa-plus mr-1"></i> Add New Exam
            </a>
        </div>
    </div>

    {{-- FILTER BAR - Compact Inline Style --}}
    <div class="bg-white shadow-soft-xl rounded-2xl p-4 mb-6">
        <div class="flex items-center justify-between mb-3 pb-2 border-b border-gray-100">
            <div class="flex items-center gap-2">
                <div class="w-6 h-6 rounded-lg bg-gradient-to-tl from-slate-600 to-slate-400 flex items-center justify-center">
                    <i class="fa fa-filter text-white text-xs"></i>
                </div>
                <div>
                    <h6 class="font-bold text-slate-700 text-sm">Filter Exams</h6>
                    <p class="text-xs text-slate-400 hidden sm:block">
                        <i class="fa fa-info-circle mr-1 text-amber-400"></i>
                        Select filters to narrow down results
                    </p>
                </div>
            </div>
            <button onclick="clearFilters()" class="text-xs text-slate-400 hover:text-slate-600 underline">
                Clear filters
            </button>
        </div>

        <div class="flex flex-wrap items-end gap-2">
            {{-- Class --}}
            <div class="flex-1 min-w-[160px]">
                <select id="filterClass"
                        class="text-sm w-full rounded-lg border border-gray-300 bg-white py-2 px-3 text-gray-700 focus:outline-none focus:border-fuchsia-300">
                    <option value="">All Classes</option>
                    @foreach($exams->pluck('class.name')->unique()->filter()->sort() as $className)
                        <option value="{{ $className }}">{{ $className }}</option>
                    @endforeach
                </select>
            </div>

            {{-- Subject --}}
            <div class="flex-1 min-w-[160px]">
                <select id="filterSubject"
                        class="text-sm w-full rounded-lg border border-gray-300 bg-white py-2 px-3 text-gray-700 focus:outline-none focus:border-fuchsia-300">
                    <option value="">All Subjects</option>
                    @foreach($exams->pluck('subject.name')->unique()->filter()->sort() as $subjectName)
                        <option value="{{ $subjectName }}">{{ $subjectName }}</option>
                    @endforeach
                </select>
            </div>

            {{-- Teacher --}}
            <div class="flex-1 min-w-[160px]">
                <select id="filterTeacher"
                        class="text-sm w-full rounded-lg border border-gray-300 bg-white py-2 px-3 text-gray-700 focus:outline-none focus:border-fuchsia-300">
                    <option value="">All Teachers</option>
                    @foreach($exams->pluck('teacher.name')->unique()->filter()->sort() as $teacherName)
                        <option value="{{ $teacherName }}">{{ $teacherName }}</option>
                    @endforeach
                </select>
            </div>

            {{-- Type --}}
            <div class="flex-1 min-w-[130px]">
                <select id="filterType"
                        class="text-sm w-full rounded-lg border border-gray-300 bg-white py-2 px-3 text-gray-700 focus:outline-none focus:border-fuchsia-300">
                    <option value="">All Types</option>
                    <option value="Mid-Term">Mid-Term</option>
                    <option value="End of Term">End of Term</option>
                    <option value="Mock">Mock</option>
                    <option value="Promotion">Promotion</option>
                </select>
            </div>

            {{-- Term --}}
            <div class="flex-1 min-w-[130px]">
                <select id="filterTerm"
                        class="text-sm w-full rounded-lg border border-gray-300 bg-white py-2 px-3 text-gray-700 focus:outline-none focus:border-fuchsia-300">
                    <option value="">All Terms</option>
                    <option value="First Term">First Term</option>
                    <option value="Second Term">Second Term</option>
                    <option value="Third Term">Third Term</option>
                </select>
            </div>
        </div>

        <div class="flex justify-between items-center mt-3 pt-2 border-t border-gray-100">
            <p class="text-xs text-slate-400">
                <i class="fa fa-info-circle mr-1 text-amber-400"></i>
                To print a specific class, subject, or teacher — select a filter first, then click <strong class="text-slate-600">Print Exam Schedule</strong>.
            </p>
            <p class="text-xs text-slate-400">
                Showing <span id="visibleCount" class="font-bold text-slate-600">{{ $exams->count() }}</span> of {{ $exams->count() }} entries
            </p>
        </div>
    </div>

    {{-- Exam Card --}}
    <div class="bg-white shadow-soft-xl rounded-2xl overflow-hidden" id="examCard">

        <div class="flex items-center gap-3 px-6 py-4 border-b border-gray-100">
            <div class="w-8 h-8 rounded-lg bg-gradient-to-tl from-purple-500 to-pink-400 flex items-center justify-center shadow-soft-md">
                <i class="fa fa-calendar-alt text-black text-xs"></i>
            </div>
            <div>
                <h6 class="font-bold text-slate-700 mb-0">Exam Entries</h6>
                <p class="text-xs text-slate-400 mt-0.5">{{ $exams->count() }} total entries</p>
            </div>
        </div>

        @if($exams->isEmpty())
            <div class="p-12 text-center">
                <div class="w-20 h-20 rounded-2xl bg-gray-100 flex items-center justify-center mb-4 mx-auto">
                    <i class="fa fa-calendar-alt text-gray-400 text-3xl"></i>
                </div>
                <p class="text-slate-500 font-semibold text-lg">No exam entries found</p>
                <p class="text-slate-400 text-sm mt-1">Click the "Add New Exam" button to create your first exam entry.</p>
            </div>
        @else
            <div id="noResults" class="p-12 text-center hidden">
                <div class="w-20 h-20 rounded-2xl bg-gray-100 flex items-center justify-center mb-4 mx-auto">
                    <i class="fa fa-search text-gray-400 text-3xl"></i>
                </div>
                <p class="text-slate-500 font-semibold text-lg">No matching entries</p>
                <p class="text-slate-400 text-sm mt-1">Try adjusting your filters.</p>
            </div>

            <div class="overflow-x-auto">
                <table class="items-center w-full mb-0 align-top border-gray-200 text-slate-500" id="examTable">
                    <thead class="align-bottom bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xxs font-bold uppercase tracking-wider text-slate-400 opacity-70">Class</th>
                            <th class="px-6 py-3 text-left text-xxs font-bold uppercase tracking-wider text-slate-400 opacity-70">Subject</th>
                            <th class="px-6 py-3 text-left text-xxs font-bold uppercase tracking-wider text-slate-400 opacity-70">Teacher</th>
                            <th class="px-6 py-3 text-center text-xxs font-bold uppercase tracking-wider text-slate-400 opacity-70">Type</th>
                            <th class="px-6 py-3 text-center text-xxs font-bold uppercase tracking-wider text-slate-400 opacity-70">Date</th>
                            <th class="px-6 py-3 text-center text-xxs font-bold uppercase tracking-wider text-slate-400 opacity-70">Time</th>
                            <th class="px-6 py-3 text-center text-xxs font-bold uppercase tracking-wider text-slate-400 opacity-70">Term</th>
                            <th class="px-6 py-3 text-center text-xxs font-bold uppercase tracking-wider text-slate-400 opacity-70">Session</th>
                            <th class="px-6 py-3 text-center text-xxs font-bold uppercase tracking-wider text-slate-400 opacity-70 no-print">Actions</th>
                        </tr>
                    </thead>
                    <tbody id="examBody">
                        @foreach($exams as $exam)
                        @php
                            $typeColors = [
                                'Mid-Term' => 'bg-blue-50 text-blue-600',
                                'End of Term' => 'bg-purple-50 text-purple-600',
                                'Mock' => 'bg-orange-50 text-orange-600',
                                'Promotion' => 'bg-green-50 text-green-600',
                            ];
                            $typeColor = $typeColors[$exam->type] ?? 'bg-gray-50 text-gray-600';
                        @endphp
                        <tr class="exam-row border-t border-gray-100 hover:bg-gray-50 transition-colors"
                            data-class="{{ $exam->class->name ?? '' }}"
                            data-subject="{{ $exam->subject->name ?? '' }}"
                            data-teacher="{{ $exam->teacher->name ?? '' }}"
                            data-type="{{ $exam->type ?? '' }}"
                            data-term="{{ $exam->term ?? '' }}"
                            data-session="{{ $exam->session ?? '' }}">
                            <td class="px-6 py-4 align-middle">
                                <div class="flex items-center gap-2">
                                    <div class="w-6 h-6 rounded-lg bg-gradient-to-tl from-blue-500 to-cyan-400 flex items-center justify-center">
                                        <i class="fa fa-chalkboard text-white text-xs"></i>
                                    </div>
                                    <span class="text-sm font-semibold text-slate-700">{{ $exam->class->name ?? 'N/A' }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4 align-middle">
                                <div class="flex items-center gap-2">
                                    <div class="w-6 h-6 rounded-lg bg-gradient-to-tl from-indigo-500 to-purple-400 flex items-center justify-center">
                                        <i class="fa fa-book text-white text-xs"></i>
                                    </div>
                                    <span class="text-sm text-slate-600">{{ $exam->subject->name ?? 'N/A' }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4 align-middle">
                                <div class="flex items-center gap-2">
                                    <div class="w-6 h-6 rounded-lg bg-gradient-to-tl from-green-500 to-emerald-400 flex items-center justify-center">
                                        <i class="fa fa-chalkboard-user text-white text-xs"></i>
                                    </div>
                                    <span class="text-sm text-slate-600">{{ $exam->teacher->name ?? 'N/A' }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4 align-middle text-center">
                                <span class="px-3 py-1 text-xs font-semibold rounded-full {{ $typeColor }}">
                                    {{ $exam->type ?? 'N/A' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 align-middle text-center">
                                <div class="flex items-center justify-center gap-1">
                                    <i class="fa fa-calendar text-slate-400 text-xs"></i>
                                    <span class="text-sm text-slate-600">
                                        {{ $exam->date ? \Carbon\Carbon::parse($exam->date)->format('d M Y') : 'N/A' }}
                                    </span>
                                </div>
                            </td>
                            <td class="px-6 py-4 align-middle text-center">
                                <div class="flex items-center justify-center gap-1">
                                    <i class="fa fa-clock text-slate-400 text-xs"></i>
                                    <span class="text-sm text-slate-600">
                                        {{ $exam->start_time ? \Carbon\Carbon::parse($exam->start_time)->format('h:i A') : 'N/A' }}
                                        -
                                        {{ $exam->end_time ? \Carbon\Carbon::parse($exam->end_time)->format('h:i A') : 'N/A' }}
                                    </span>
                                </div>
                            </td>
                            <td class="px-6 py-4 align-middle text-center">
                                <span class="px-3 py-1 text-xs font-semibold rounded-full bg-purple-50 text-purple-600">
                                    {{ $exam->term ?? 'N/A' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 align-middle text-center">
                                <span class="px-3 py-1 text-xs font-semibold rounded-full bg-cyan-50 text-cyan-600">
                                    {{ $exam->session ?? 'N/A' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 align-middle text-center no-print">
                                <div class="flex items-center justify-center gap-2">
                                    <a href="{{ route('tenant.exam.edit', [$subdomain, $exam->id]) }}"
                                       class="w-7 h-7 rounded-lg bg-amber-50 text-amber-500 flex items-center justify-center hover:bg-amber-100 transition-colors"
                                       title="Edit">
                                        <i class="fa fa-pen text-xs"></i>
                                    </a>
                                    <a href="{{ route('tenant.exam.delete', [$subdomain, $exam->id]) }}"
                                       onclick="return confirm('Are you sure you want to delete this exam entry?')"
                                       class="w-7 h-7 rounded-lg bg-red-50 text-red-500 flex items-center justify-center hover:bg-red-100 transition-colors"
                                       title="Delete">
                                        <i class="fa fa-trash text-xs"></i>
                                    </a>
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
    <div class="mt-5 p-4 bg-gradient-to-r from-blue-50 to-cyan-50 rounded-xl border border-blue-100 no-print">
        <div class="flex items-start gap-3">
            <div class="w-8 h-8 rounded-lg bg-gradient-to-tl from-blue-500 to-cyan-400 flex items-center justify-center flex-shrink-0">
                <i class="fa fa-info-circle text-white text-xs"></i>
            </div>
            <div>
                <p class="text-sm font-semibold text-blue-800">Exam Management</p>
                <p class="text-xs text-blue-600 mt-0.5">
                    Add, edit, or remove class exam entries. Each entry represents a subject examination scheduled for a specific class on a particular date and time.
                </p>
            </div>
        </div>
    </div>

</div>

{{-- PRINT STYLES --}}
<style>
@media print {
    body * { visibility: hidden; }
    #printArea, #printArea * { visibility: visible; }
    #printArea { position: absolute; left: 0; top: 0; width: 100%; }
    .no-print { display: none !important; }

    .print-header { text-align: center; margin-bottom: 16px; }
    .print-header h2 { font-size: 18px; font-weight: 700; margin-bottom: 4px; }
    .print-header p { font-size: 12px; color: #64748b; }

    .print-class-section { margin-bottom: 28px; page-break-inside: avoid; }
    .print-class-title {
        font-size: 14px; font-weight: 700;
        background: #1e293b; color: white;
        padding: 6px 12px; border-radius: 4px;
        margin-bottom: 8px;
    }

    .print-grid {
        width: 100%;
        border-collapse: collapse;
        font-size: 11px;
    }
    .print-grid th {
        background: #f1f5f9;
        border: 1px solid #cbd5e1;
        padding: 6px 8px;
        text-align: center;
        font-weight: 700;
        font-size: 10px;
        text-transform: uppercase;
    }
    .print-grid td {
        border: 1px solid #e2e8f0;
        padding: 5px 8px;
        text-align: center;
        font-size: 10px;
        vertical-align: top;
    }
    .empty-cell { color: #cbd5e1; }
}
</style>

{{-- Hidden print area --}}
<div id="printArea" style="display:none;"></div>

{{-- JAVASCRIPT --}}
<script>
// ── LIVE FILTER ──
const filterClass   = document.getElementById('filterClass');
const filterSubject = document.getElementById('filterSubject');
const filterTeacher = document.getElementById('filterTeacher');
const filterType    = document.getElementById('filterType');
const filterTerm    = document.getElementById('filterTerm');
const rows          = document.querySelectorAll('.exam-row');
const noResults     = document.getElementById('noResults');
const visibleCount  = document.getElementById('visibleCount');

function applyFilters() {
    const cls     = filterClass.value.toLowerCase();
    const subject = filterSubject.value.toLowerCase();
    const teacher = filterTeacher.value.toLowerCase();
    const type    = filterType.value.toLowerCase();
    const term    = filterTerm.value.toLowerCase();

    let visible = 0;

    rows.forEach(row => {
        const rowClass   = row.dataset.class.toLowerCase();
        const rowSubject = row.dataset.subject.toLowerCase();
        const rowTeacher = row.dataset.teacher.toLowerCase();
        const rowType    = row.dataset.type.toLowerCase();
        const rowTerm    = row.dataset.term.toLowerCase();

        const match =
            (!cls     || rowClass === cls) &&
            (!subject || rowSubject === subject) &&
            (!teacher || rowTeacher === teacher) &&
            (!type    || rowType === type) &&
            (!term    || rowTerm === term);

        row.style.display = match ? '' : 'none';
        if (match) visible++;
    });

    visibleCount.textContent = visible;
    if (noResults) {
        noResults.classList.toggle('hidden', visible > 0);
    }
    const tableContainer = document.querySelector('.overflow-x-auto');
    if (tableContainer) {
        tableContainer.style.display = visible === 0 ? 'none' : '';
    }
}

if (filterClass) filterClass.addEventListener('change', applyFilters);
if (filterSubject) filterSubject.addEventListener('change', applyFilters);
if (filterTeacher) filterTeacher.addEventListener('change', applyFilters);
if (filterType) filterType.addEventListener('change', applyFilters);
if (filterTerm) filterTerm.addEventListener('change', applyFilters);

function clearFilters() {
    if (filterClass) filterClass.value = '';
    if (filterSubject) filterSubject.value = '';
    if (filterTeacher) filterTeacher.value = '';
    if (filterType) filterType.value = '';
    if (filterTerm) filterTerm.value = '';
    applyFilters();
}

// ── PRINT EXAM SCHEDULE ──
function printExamSchedule() {
    const visibleRows = [...rows].filter(r => r.style.display !== 'none');

    if (visibleRows.length === 0) {
        alert('No exam entries to print. Please adjust your filters.');
        return;
    }

    const grouped = {};
    visibleRows.forEach(row => {
        const cls = row.dataset.class || 'Unknown Class';
        if (!grouped[cls]) grouped[cls] = [];
        
        // Get session from the session cell (8th column - index 7)
        const sessionCell = row.cells[7];
        const session = sessionCell ? sessionCell.textContent.trim() : '';
        
        grouped[cls].push({
            type:    row.dataset.type || 'N/A',
            subject: row.dataset.subject || 'N/A',
            teacher: row.dataset.teacher || 'N/A',
            date:    row.cells[4]?.textContent.trim() || 'N/A',
            time:    row.cells[5]?.textContent.trim() || 'N/A',
            term:    row.dataset.term || 'N/A',
            session: session,
        });
    });

    const schoolName = '{{ app("tenant")->name ?? "CoreDesk School" }}';
    const now = new Date().toLocaleDateString('en-NG', { weekday:'long', year:'numeric', month:'long', day:'numeric' });

    let html = `
        <div class="print-header">
            <h2>${schoolName}</h2>
            <h3 style="font-size: 14px; font-weight: 600; margin-top: 4px;">Examination Schedule</h3>
            <p>Printed on: ${now}</p>
            <hr style="margin: 10px 0; border-color: #cbd5e1;">
        </div>
    `;

    Object.entries(grouped).forEach(([className, entries]) => {
        const term = entries[0]?.term || '';
        const session = entries[0]?.session || '';
        html += `
            <div class="print-class-section">
                <div class="print-class-title">
                    📚 ${className}
                </div>
                <div style="margin-bottom: 8px; font-size: 11px; color: #475569;">
                    <strong>Term:</strong> ${term} &nbsp;|&nbsp; 
                    <strong>Academic Session:</strong> ${session}
                </div>
                <table class="print-grid">
                    <thead>
                        <tr>
                            <th style="width: 25%">Subject</th>
                            <th style="width: 25%">Teacher</th>
                            <th style="width: 15%">Type</th>
                            <th style="width: 15%">Date</th>
                            <th style="width: 20%">Time</th>
                        </tr>
                    </thead>
                    <tbody>
                        ${entries.map(entry => `
                            <tr>
                                <td><strong>${entry.subject}</strong></strong></td>
                                <td>${entry.teacher}</td>
                                <td>${entry.type}</td>
                                <td>${entry.date}</td>
                                <td>${entry.time}</td>
                            </tr>
                        `).join('')}
                    </tbody>
                </table>
            </div>
            <div style="margin-bottom: 20px;"></div>
        `;
    });

    // Add footer with school info
    html += `
        <div style="margin-top: 30px; padding-top: 10px; border-top: 1px solid #cbd5e1; text-align: center; font-size: 10px; color: #94a3b8;">
            <p>© ${new Date().getFullYear()} ${schoolName} - All Rights Reserved</p>
            <p>This is a computer-generated document. No signature required.</p>
        </div>
    `;

    const printArea = document.getElementById('printArea');
    printArea.innerHTML = html;
    printArea.style.display = 'block';
    window.print();
    printArea.style.display = 'none';
}
</script>

@endsection