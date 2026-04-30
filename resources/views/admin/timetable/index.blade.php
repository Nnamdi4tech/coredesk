@extends('layouts.admin')

@section('content')

@php $subdomain = request()->route('subdomain'); @endphp

<div class="w-full px-6 py-6 mx-auto">

    {{-- Success / Error Messages --}}
    @if(session('success'))
        <div id="successMsg" class="flex items-center gap-3 px-4 py-3 mb-6 text-sm font-semibold text-green-800 bg-green-50 border border-green-200 rounded-xl">
            <div class="w-7 h-7 rounded-lg bg-gradient-to-tl from-green-500 to-emerald-400 flex items-center justify-center flex-shrink-0">
                <i class="fa fa-check text-white text-xs"></i>
            </div>
            {{ session('success') }}
            <button onclick="this.parentElement.remove()" class="ml-auto text-green-500 hover:text-green-700">
                <i class="fa fa-times text-xs"></i>
            </button>
        </div>
    @endif

    @if(session('error'))
        <div class="flex items-center gap-3 px-4 py-3 mb-6 text-sm font-semibold text-red-800 bg-red-50 border border-red-200 rounded-xl">
            <div class="w-7 h-7 rounded-lg bg-gradient-to-tl from-red-500 to-rose-400 flex items-center justify-center flex-shrink-0">
                <i class="fa fa-exclamation-circle text-white text-xs"></i>
            </div>
            {{ session('error') }}
            <button onclick="this.parentElement.remove()" class="ml-auto text-red-500 hover:text-red-700">
                <i class="fa fa-times text-xs"></i>
            </button>
        </div>
    @endif

    {{-- PAGE HEADER --}}
    <div class="flex flex-wrap items-center justify-between mb-6 -mx-3">
        <div class="px-3">
            <h3 class="text-2xl font-bold text-slate-700 mb-1">School Class-Schedule Timetable</h3>
            <p class="text-sm text-slate-400">
                <i class="fa fa-home mr-1 text-black"></i> Dashboard
                <span class="mx-1 text-slate-300">/</span>
                <span class="text-slate-600">Timetable Management</span>
            </p>
        </div>
        
        <div class="px-3 mt-3 md:mt-0 flex gap-2">
            <button onclick="printTimetable()"
                class="px-4 py-2 text-sm font-semibold text-white rounded-lg bg-gradient-to-tl from-blue-600 to-cyan-500 shadow-soft-md hover:shadow-soft-xl hover:scale-105 transition-all">
                <i class="fa fa-print mr-1"></i> Print Timetable
            </button>
            <a href="{{ route('tenant.timetable.create', $subdomain) }}"
               class="px-4 py-2 text-sm font-semibold text-white rounded-lg bg-gradient-to-tl from-green-600 to-emerald-500 shadow-soft-md hover:shadow-soft-xl hover:scale-105 transition-all">
                <i class="fa fa-plus mr-1"></i> Add New Entry
            </a>
        </div>
    </div>

    {{-- FILTER BAR - Compact Inline Style --}}
<div class="bg-white shadow-soft-xl rounded-2xl p-4 mb-6">
    <!-- Header with title and clear button -->
    <div class="flex items-center justify-between mb-3 pb-2 border-b border-gray-100">
        <div class="flex items-center gap-2">
            <div class="w-6 h-6 rounded-lg bg-gradient-to-tl from-slate-600 to-slate-400 flex items-center justify-center">
                <i class="fa fa-filter text-white text-xs"></i>
            </div>
            <div>
                <h6 class="font-bold text-slate-700 text-sm">Filter Timetable</h6>
                <p class="text-xs text-slate-400 hidden sm:block text-black">
                    <i class="fa fa-info-circle mr-1 text-amber-400 text-black"></i>
                    Select filters to narrow down results
                </p>
            </div>
        </div>
        <button onclick="clearFilters()" class="text-xs text-slate-400 hover:text-slate-600 underline">
            Clear filters
        </button>
    </div>

    <!-- Inline filters row -->
    <div class="flex flex-wrap items-end gap-2">
        {{-- Class --}}
        <div class="flex-1 min-w-[160px]">
            <select id="filterClass"
                    class="text-sm w-full rounded-lg border border-gray-300 bg-white py-2 px-3 text-gray-700 focus:outline-none focus:border-fuchsia-300">
                <option value="">All Classes</option>
                @foreach($timetables->pluck('class.name')->unique()->filter()->sort() as $className)
                    <option value="{{ $className }}">{{ $className }}</option>
                @endforeach
            </select>
        </div>

        {{-- Day --}}
        <div class="flex-1 min-w-[130px]">
            <select id="filterDay"
                    class="text-sm w-full rounded-lg border border-gray-300 bg-white py-2 px-3 text-gray-700 focus:outline-none focus:border-fuchsia-300">
                <option value="">All Days</option>
                <option value="Monday">Monday</option>
                <option value="Tuesday">Tuesday</option>
                <option value="Wednesday">Wednesday</option>
                <option value="Thursday">Thursday</option>
                <option value="Friday">Friday</option>
                <option value="Saturday">Saturday</option>
                <option value="Sunday">Sunday</option>
            </select>
        </div>

        {{-- Subject --}}
        <div class="flex-1 min-w-[160px]">
            <select id="filterSubject"
                    class="text-sm w-full rounded-lg border border-gray-300 bg-white py-2 px-3 text-gray-700 focus:outline-none focus:border-fuchsia-300">
                <option value="">All Subjects</option>
                @foreach($timetables->pluck('subject.name')->unique()->filter()->sort() as $subjectName)
                    <option value="{{ $subjectName }}">{{ $subjectName }}</option>
                @endforeach
            </select>
        </div>

        {{-- Teacher --}}
        <div class="flex-1 min-w-[160px]">
            <select id="filterTeacher"
                    class="text-sm w-full rounded-lg border border-gray-300 bg-white py-2 px-3 text-gray-700 focus:outline-none focus:border-fuchsia-300">
                <option value="">All Teachers</option>
                @foreach($timetables->pluck('teacher.name')->unique()->filter()->sort() as $teacherName)
                    <option value="{{ $teacherName }}">{{ $teacherName }}</option>
                @endforeach
            </select>
        </div>
    </div>

    {{-- Results count --}}
    <div class="flex justify-between items-center mt-3 pt-2 border-t border-gray-100">
        <p class="text-xs text-slate-400">
            <i class="fa fa-info-circle mr-1 text-amber-400"></i>
            To print a specific class, subject, or teacher — select a filter first, then click <strong class="text-slate-600">Print Timetable</strong>.
        </p>
        <p class="text-xs text-slate-400">
            Showing <span id="visibleCount" class="font-bold text-slate-600">{{ $timetables->count() }}</span> of {{ $timetables->count() }} entries
        </p>
    </div>
</div>

    {{-- Timetable Card --}}
    <div class="bg-white shadow-soft-xl rounded-2xl overflow-hidden" id="timetableCard">

        <div class="flex items-center gap-3 px-6 py-4 border-b border-gray-100">
            <div class="w-8 h-8 rounded-lg bg-gradient-to-tl from-purple-500 to-pink-400 flex items-center justify-center shadow-soft-md">
                <i class="fa fa-calendar-alt text-black text-xs"></i>
            </div>
            <div>
                <h6 class="font-bold text-slate-700 mb-0">Timetable Entries</h6>
                <p class="text-xs text-slate-400 mt-0.5">{{ $timetables->count() }} total entries</p>
            </div>
        </div>

        @if($timetables->isEmpty())
            <div class="p-12 text-center">
                <div class="w-20 h-20 rounded-2xl bg-gray-100 flex items-center justify-center mb-4 mx-auto">
                    <i class="fa fa-calendar-alt text-gray-400 text-3xl"></i>
                </div>
                <p class="text-slate-500 font-semibold text-lg">No timetable entries found</p>
                <p class="text-slate-400 text-sm mt-1">Click the "Add New Entry" button to create your first timetable entry.</p>
            </div>
        @else
            {{-- No results message --}}
            <div id="noResults" class="p-12 text-center hidden">
                <div class="w-20 h-20 rounded-2xl bg-gray-100 flex items-center justify-center mb-4 mx-auto">
                    <i class="fa fa-search text-gray-400 text-3xl"></i>
                </div>
                <p class="text-slate-500 font-semibold text-lg">No matching entries</p>
                <p class="text-slate-400 text-sm mt-1">Try adjusting your filters.</p>
            </div>

            <div class="overflow-x-auto">
                <table class="items-center w-full mb-0 align-top border-gray-200 text-slate-500" id="timetableTable">
                    <thead class="align-bottom bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xxs font-bold uppercase tracking-wider text-slate-400 opacity-70">Class</th>
                            <th class="px-6 py-3 text-left text-xxs font-bold uppercase tracking-wider text-slate-400 opacity-70">Subject</th>
                            <th class="px-6 py-3 text-left text-xxs font-bold uppercase tracking-wider text-slate-400 opacity-70">Teacher</th>
                            <th class="px-6 py-3 text-center text-xxs font-bold uppercase tracking-wider text-slate-400 opacity-70">Day</th>
                            <th class="px-6 py-3 text-center text-xxs font-bold uppercase tracking-wider text-slate-400 opacity-70">Time</th>
                            <th class="px-6 py-3 text-center text-xxs font-bold uppercase tracking-wider text-slate-400 opacity-70">Term</th>
                            <th class="px-6 py-3 text-center text-xxs font-bold uppercase tracking-wider text-slate-400 opacity-70">Session</th>
                            <th class="px-6 py-3 text-center text-xxs font-bold uppercase tracking-wider text-slate-400 opacity-70 no-print">Actions</th>
                        </tr>
                    </thead>
                    <tbody id="timetableBody">
                        @foreach($timetables as $t)
                        @php
                            $dayColors = [
                                'Monday'    => 'bg-blue-50 text-blue-600',
                                'Tuesday'   => 'bg-indigo-50 text-indigo-600',
                                'Wednesday' => 'bg-purple-50 text-purple-600',
                                'Thursday'  => 'bg-green-50 text-green-600',
                                'Friday'    => 'bg-amber-50 text-amber-600',
                                'Saturday'  => 'bg-orange-50 text-orange-600',
                                'Sunday'    => 'bg-red-50 text-red-600',
                            ];
                            $dayColor = $dayColors[$t->day] ?? 'bg-gray-50 text-gray-600';
                        @endphp
                        <tr class="timetable-row border-t border-gray-100 hover:bg-gray-50 transition-colors"
                            data-class="{{ $t->class->name ?? '' }}"
                            data-day="{{ $t->day ?? '' }}"
                            data-subject="{{ $t->subject->name ?? '' }}"
                            data-teacher="{{ $t->teacher->name ?? '' }}">
                            <td class="px-6 py-4 align-middle">
                                <div class="flex items-center gap-2">
                                    <div class="w-6 h-6 rounded-lg bg-gradient-to-tl from-blue-500 to-cyan-400 flex items-center justify-center">
                                        <i class="fa fa-chalkboard text-white text-xs"></i>
                                    </div>
                                    <span class="text-sm font-semibold text-slate-700">{{ $t->class->name ?? 'N/A' }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4 align-middle">
                                <div class="flex items-center gap-2">
                                    <div class="w-6 h-6 rounded-lg bg-gradient-to-tl from-indigo-500 to-purple-400 flex items-center justify-center">
                                        <i class="fa fa-book text-white text-xs"></i>
                                    </div>
                                    <span class="text-sm text-slate-600">{{ $t->subject->name ?? 'N/A' }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4 align-middle">
                                <div class="flex items-center gap-2">
                                    <div class="w-6 h-6 rounded-lg bg-gradient-to-tl from-green-500 to-emerald-400 flex items-center justify-center">
                                        <i class="fa fa-chalkboard-user text-white text-xs"></i>
                                    </div>
                                    <span class="text-sm text-slate-600">{{ $t->teacher->name ?? 'N/A' }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4 align-middle text-center">
                                <span class="px-3 py-1 text-xs font-semibold rounded-full {{ $dayColor }}">
                                    {{ $t->day }}
                                </span>
                            </td>
                            <td class="px-6 py-4 align-middle text-center">
                                <div class="flex items-center justify-center gap-1">
                                    <i class="fa fa-clock text-slate-400 text-xs"></i>
                                    <span class="text-sm text-slate-600">{{ $t->start_time }} - {{ $t->end_time }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4 align-middle text-center">
                                <span class="px-3 py-1 text-xs font-semibold rounded-full bg-purple-50 text-purple-600">
                                    {{ $t->term ?? 'N/A' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 align-middle text-center">
                                <span class="px-3 py-1 text-xs font-semibold rounded-full bg-cyan-50 text-cyan-600">
                                    {{ $t->session ?? 'N/A' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 align-middle text-center no-print">
                                <div class="flex items-center justify-center gap-2">
                                    <a href="{{ route('tenant.timetable.edit', [$subdomain, $t->id]) }}"
                                       class="w-7 h-7 rounded-lg bg-amber-50 text-amber-500 flex items-center justify-center hover:bg-amber-100 transition-colors"
                                       title="Edit">
                                        <i class="fa fa-pen text-xs"></i>
                                    </a>
                                    <a href="{{ route('tenant.timetable.delete', [$subdomain, $t->id]) }}"
                                       onclick="return confirm('Are you sure you want to delete this timetable entry?')"
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
                <p class="text-sm font-semibold text-blue-800">Timetable Management</p>
                <p class="text-xs text-blue-600 mt-0.5">
                    Add, edit, or remove class timetable entries. Each entry represents a subject scheduled for a specific class on a particular day and time.
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
    .print-grid td .subject-name { font-weight: 600; color: #0f172a; }
    .print-grid td .teacher-name { font-size: 9px; color: #64748b; margin-top: 2px; }
    .print-grid td .time-label   { font-size: 9px; color: #94a3b8; }
    .empty-cell { color: #cbd5e1; }
}
</style>

{{-- Hidden print area --}}
<div id="printArea" style="display:none;"></div>

{{-- JAVASCRIPT --}}
<script>
// ── LIVE FILTER ──
const filterClass   = document.getElementById('filterClass');
const filterDay     = document.getElementById('filterDay');
const filterSubject = document.getElementById('filterSubject');
const filterTeacher = document.getElementById('filterTeacher');
const rows          = document.querySelectorAll('.timetable-row');
const noResults     = document.getElementById('noResults');
const visibleCount  = document.getElementById('visibleCount');

function applyFilters() {
    const cls     = filterClass.value.toLowerCase();
    const day     = filterDay.value.toLowerCase();
    const subject = filterSubject.value.toLowerCase();
    const teacher = filterTeacher.value.toLowerCase();

    let visible = 0;

    rows.forEach(row => {
        const rowClass   = row.dataset.class.toLowerCase();
        const rowDay     = row.dataset.day.toLowerCase();
        const rowSubject = row.dataset.subject.toLowerCase();
        const rowTeacher = row.dataset.teacher.toLowerCase();

        const match =
            (!cls     || rowClass === cls) &&
            (!day     || rowDay === day) &&
            (!subject || rowSubject === subject) &&
            (!teacher || rowTeacher === teacher);

        row.style.display = match ? '' : 'none';
        if (match) visible++;
    });

    visibleCount.textContent = visible;
    noResults.classList.toggle('hidden', visible > 0);
    document.querySelector('.overflow-x-auto').style.display = visible === 0 ? 'none' : '';
}

filterClass.addEventListener('change', applyFilters);
filterDay.addEventListener('change', applyFilters);
filterSubject.addEventListener('change', applyFilters);
filterTeacher.addEventListener('change', applyFilters);

function clearFilters() {
    filterClass.value   = '';
    filterDay.value     = '';
    filterSubject.value = '';
    filterTeacher.value = '';
    applyFilters();
}

// ── PRINT TIMETABLE ──
function printTimetable() {
    // Collect only visible rows
    const visibleRows = [...rows].filter(r => r.style.display !== 'none');

    if (visibleRows.length === 0) {
        alert('No timetable entries to print. Please adjust your filters.');
        return;
    }

    // Group by class
    const grouped = {};
    visibleRows.forEach(row => {
        const cls = row.dataset.class || 'Unknown Class';
        if (!grouped[cls]) grouped[cls] = [];
        grouped[cls].push({
            day:     row.dataset.day,
            subject: row.dataset.subject,
            teacher: row.dataset.teacher,
            time:    row.querySelector('.fa-clock').nextElementSibling.textContent.trim(),
            term:    row.cells[5].textContent.trim(),
            session: row.cells[6].textContent.trim(),
        });
    });

    const days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
    const schoolName = '{{ app("tenant")->name ?? "School" }}';
    const now = new Date().toLocaleDateString('en-NG', { weekday:'long', year:'numeric', month:'long', day:'numeric' });

    // school name display start here
    let html = `
    <div class="print-header">
        <h2 style="font-size:20px;font-weight:700;color:#1e293b;margin:0 0 4px;">${schoolName}</h2>
        <p style="font-size:13px;color:#475569;margin:0 0 2px;font-weight:600;">Class Timetable</p>
        <p style="font-size:11px;color:#94a3b8;margin:0;">Printed on ${now}</p>
        <hr style="margin:10px 0;border:none;border-top:2px solid #1e293b;">
    </div>
   `;

    // ends here

    Object.entries(grouped).forEach(([className, entries]) => {
        // Get unique times for this class
        const times = [...new Set(entries.map(e => e.time))].sort();
        // Get days present
        const daysPresent = days.filter(d => entries.some(e => e.day === d));

        const term    = entries[0]?.term    || '';
        const session = entries[0]?.session || '';

        html += `
            <div class="print-class-section">
                <div class="print-class-title">
                    ${className} &nbsp;|&nbsp; Term: ${term} &nbsp;|&nbsp; Session: ${session}
                </div>
                <table class="print-grid">
                    <thead>
                        <tr>
                            <th>Time</th>
                            ${daysPresent.map(d => `<th>${d}</th>`).join('')}
                        </tr>
                    </thead>
                    <tbody>
                        ${times.map(time => `
                            <tr>
                                <td><strong>${time}</strong></td>
                                ${daysPresent.map(day => {
                                    const entry = entries.find(e => e.day === day && e.time === time);
                                    return entry
                                        ? `<td>
                                            <div class="subject-name">${entry.subject}</div>
                                            <div class="teacher-name">${entry.teacher}</div>
                                           </td>`
                                        : `<td class="empty-cell">—</td>`;
                                }).join('')}
                            </tr>
                        `).join('')}
                    </tbody>
                </table>
            </div>
        `;
    });

    document.getElementById('printArea').innerHTML = html;
    document.getElementById('printArea').style.display = 'block';
    window.print();
    document.getElementById('printArea').style.display = 'none';
}
</script>

@endsection