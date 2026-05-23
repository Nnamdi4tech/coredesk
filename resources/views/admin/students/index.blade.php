@extends('layouts.admin')

@section('content')

@php $subdomain = request()->route('subdomain'); @endphp

<div class="w-full px-6 py-6 mx-auto">

    {{-- PAGE HEADER --}}
    <div class="flex flex-wrap items-center justify-between mb-6 -mx-3">
        <div class="px-3">
            <h3 class="text-2xl font-bold text-slate-700 mb-1">Students</h3>
            <p class="text-sm text-slate-400">
                <i class="fa fa-home mr-1"></i> Dashboard
                <span class="mx-1 text-slate-300">/</span>
                <span class="text-slate-600">Students Management</span>
            </p>
        </div>
        <div class="px-3 flex gap-3 mt-3 md:mt-0">
            <button onclick="printStudentCards()"
               class="px-5 py-2 text-sm font-semibold text-white rounded-lg bg-gradient-to-tl from-green-600 to-emerald-500 shadow-soft-md hover:shadow-soft-xl transition-all hover:scale-105">
                <i class="fa fa-print mr-1"></i> Print Login Cards
            </button>
            <a href="{{ route('tenant.students.create', $subdomain) }}"
               class="px-5 py-2 text-sm font-semibold text-white rounded-lg bg-gradient-to-tl from-gray-900 to-slate-700 shadow-soft-md hover:shadow-soft-xl transition-all hover:scale-105">
                <i class="fa fa-plus mr-1"></i> Add Student
            </a>
        </div>
    </div>

    {{-- STAT CARDS ROW 1 — 4 CARDS --}}
    <div class="flex flex-wrap -mx-3 mb-6">
        
        <!-- card1 - Total Students -->
        <div class="w-full max-w-full px-3 mb-6 sm:w-1/2 sm:flex-none xl:mb-0 xl:w-1/4">
            <div class="relative flex flex-col min-w-0 break-words bg-white shadow-soft-xl rounded-2xl bg-clip-border">
                <div class="flex-auto p-4">
                    <div class="flex flex-row -mx-3">
                        <div class="flex-none w-2/3 max-w-full px-3">
                            <div>
                                <p class="mb-0 font-sans text-sm font-semibold leading-normal">Total Students</p>
                                <h5 class="mb-0 font-bold">
                                    {{ $totalStudents }}
                                    <span class="text-sm leading-normal font-weight-bolder text-lime-500">enrolled</span>
                                </h5>
                            </div>
                        </div>
                        <div class="px-3 text-right basis-1/3">
                            <div class="inline-block w-12 h-12 text-center rounded-lg bg-gradient-to-tl from-blue-500 to-cyan-400">
                                <i class="fa fa-user-graduate text-lg relative top-3.5 text-primary"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- card2 - Male Students -->
        <div class="w-full max-w-full px-3 mb-6 sm:w-1/2 sm:flex-none xl:mb-0 xl:w-1/4">
            <div class="relative flex flex-col min-w-0 break-words bg-white shadow-soft-xl rounded-2xl bg-clip-border">
                <div class="flex-auto p-4">
                    <div class="flex flex-row -mx-3">
                        <div class="flex-none w-2/3 max-w-full px-3">
                            <div>
                                <p class="mb-0 font-sans text-sm font-semibold leading-normal">Male Students</p>
                                <h5 class="mb-0 font-bold">
                                    {{ $maleStudents }}
                                    <span class="text-sm leading-normal font-weight-bolder text-blue-500">{{ $malePercentage }}%</span>
                                </h5>
                            </div>
                        </div>
                        <div class="px-3 text-right basis-1/3">
                            <div class="inline-block w-12 h-12 text-center rounded-lg bg-gradient-to-tl from-blue-600 to-indigo-400">
                                <i class="fa fa-mars text-lg relative top-3.5 text-primary"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- card3 - Female Students -->
        <div class="w-full max-w-full px-3 mb-6 sm:w-1/2 sm:flex-none xl:mb-0 xl:w-1/4">
            <div class="relative flex flex-col min-w-0 break-words bg-white shadow-soft-xl rounded-2xl bg-clip-border">
                <div class="flex-auto p-4">
                    <div class="flex flex-row -mx-3">
                        <div class="flex-none w-2/3 max-w-full px-3">
                            <div>
                                <p class="mb-0 font-sans text-sm font-semibold leading-normal">Female Students</p>
                                <h5 class="mb-0 font-bold">
                                    {{ $femaleStudents }}
                                    <span class="text-sm leading-normal font-weight-bolder text-pink-500">{{ $femalePercentage }}%</span>
                                </h5>
                            </div>
                        </div>
                        <div class="px-3 text-right basis-1/3">
                            <div class="inline-block w-12 h-12 text-center rounded-lg bg-gradient-to-tl from-pink-500 to-rose-400">
                                <i class="fa fa-venus text-lg relative top-3.5 text-primary"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- card4 - New This Month -->
        <div class="w-full max-w-full px-3 sm:w-1/2 sm:flex-none xl:w-1/4">
            <div class="relative flex flex-col min-w-0 break-words bg-white shadow-soft-xl rounded-2xl bg-clip-border">
                <div class="flex-auto p-4">
                    <div class="flex flex-row -mx-3">
                        <div class="flex-none w-2/3 max-w-full px-3">
                            <div>
                                <p class="mb-0 font-sans text-sm font-semibold leading-normal">New This Month</p>
                                <h5 class="mb-0 font-bold">
                                    {{ $newThisMonth }}
                                    <span class="text-sm leading-normal font-weight-bolder text-green-500">new</span>
                                </h5>
                            </div>
                        </div>
                        <div class="px-3 text-right basis-1/3">
                            <div class="inline-block w-12 h-12 text-center rounded-lg bg-gradient-to-tl from-green-500 to-emerald-400">
                                <i class="fa fa-user-plus text-lg relative top-3.5 text-primary"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    {{-- SUCCESS MESSAGE --}}
    @if(session('success'))
        <div class="p-4 mb-6 text-sm text-green-700 bg-green-50 border border-green-200 rounded-2xl flex items-center gap-3">
            <div class="w-8 h-8 rounded-lg bg-gradient-to-tl from-green-500 to-emerald-400 flex items-center justify-center flex-shrink-0">
                <i class="fa fa-check text-black text-xs"></i>
            </div>
            <div>
                <p class="font-semibold">Success!</p>
                <p class="text-green-600 text-xs mt-0.5">{{ session('success') }}</p>
            </div>
            <button onclick="this.parentElement.remove()" class="ml-auto text-green-400 hover:text-green-600">
                <i class="fa fa-times text-black text-xs"></i>
            </button>
        </div>
    @endif

    {{-- STUDENTS TABLE --}}
    <div id="studentsWrapper" class="bg-white rounded-2xl shadow-soft-xl overflow-hidden w-full">

        {{-- Table Header --}}
        <div class="flex flex-wrap items-center justify-between px-6 py-4 border-b border-gray-100 gap-3">
            <div>
                <h6 class="font-bold text-slate-700">All Students</h6>
                <p class="text-xs text-slate-400 mt-0.5">
                    {{ $students->total() }} {{ Str::plural('student', $students->total()) }} total
                </p>
            </div>
            <div class="flex items-center gap-3">
                {{-- Search --}}
                <div class="relative">
                    <i class="fa fa-search absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-xs"></i>
                    <input type="text"
                           id="searchInput"
                           placeholder="Search students..."
                           onkeyup="filterTable()"
                           class="pl-8 pr-4 py-2 text-sm border border-gray-200 rounded-lg focus:outline-none focus:border-fuchsia-300 w-52" />
                </div>
                {{-- Class Filter --}}
                <select id="classFilter"
                        onchange="filterTable()"
                        class="px-3 py-2 text-sm border border-gray-200 rounded-lg focus:outline-none focus:border-fuchsia-300 text-slate-500">
                    <option value="">All Classes</option>
                    @foreach($classes as $class)
                        <option value="{{ $class->name }}">{{ $class->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        {{-- Table --}}
        <div class="overflow-x-auto">
            <table class="items-center w-full mb-0 align-top border-gray-200 text-slate-500" id="studentsTable">
                <thead class="align-bottom bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xxs font-bold uppercase tracking-wider text-slate-400 opacity-70">#</th>
                        <th class="px-6 py-3 text-left text-xxs font-bold uppercase tracking-wider text-slate-400 opacity-70">Student</th>
                        <th class="px-6 py-3 text-left text-xxs font-bold uppercase tracking-wider text-slate-400 opacity-70">Student ID</th>
                        <th class="px-6 py-3 text-left text-xxs font-bold uppercase tracking-wider text-slate-400 opacity-70">Class</th>
                        <th class="px-6 py-3 text-left text-xxs font-bold uppercase tracking-wider text-slate-400 opacity-70">Gender</th>
                        <th class="px-6 py-3 text-left text-xxs font-bold uppercase tracking-wider text-slate-400 opacity-70">Teacher</th>
                        <th class="px-6 py-3 text-center text-xxs font-bold uppercase tracking-wider text-slate-400 opacity-70">Actions</th>
                    </tr>
                </thead>
                <tbody>

                    @forelse($students as $student)
                    <tr class="border-t border-gray-100 hover:bg-gray-50 transition-colors">

                        <td class="px-6 py-3 align-middle">
                            <span class="text-xs text-slate-400">{{ $students->firstItem() + $loop->index }}</span>
                        </td>

                        <td class="px-6 py-3 align-middle">
                            <div class="flex items-center gap-3">
                                <div class="w-9 h-9 rounded-xl flex items-center justify-center text-black text-sm font-bold shadow-soft-md flex-shrink-0
                                    {{ $student->gender === 'female'
                                        ? 'bg-gradient-to-tl from-pink-500 to-rose-400'
                                        : 'bg-gradient-to-tl from-blue-500 to-cyan-400' }}">
                                    {{ strtoupper(substr($student->name, 0, 2)) }}
                                </div>
                                <div>
                                    <p class="text-sm font-semibold text-slate-700 mb-0">{{ $student->name }}</p>
                                    <p class="text-xs text-slate-400">{{ $student->email ?? '—' }}</p>
                                </div>
                            </div>
                        </td>

                        <td class="px-6 py-3 align-middle">
                            <span class="text-xs font-mono font-semibold bg-slate-100 text-slate-600 px-2 py-1 rounded-lg">
                                {{ $student->student_id }}
                            </span>
                        </td>

                        <td class="px-6 py-3 align-middle">
                            @if($student->schoolClass)
                                @php
                                    $classColors = [
                                        'JSS1' => 'bg-blue-50 text-blue-600',
                                        'JSS2' => 'bg-cyan-50 text-cyan-600',
                                        'JSS3' => 'bg-teal-50 text-teal-600',
                                        'SS1'  => 'bg-purple-50 text-purple-600',
                                        'SS2'  => 'bg-orange-50 text-orange-600',
                                        'SS3'  => 'bg-red-50 text-red-600',
                                    ];
                                    $className = $student->schoolClass->name;
                                    $classColor = $classColors[$className] ?? 'bg-gray-100 text-gray-600';
                                @endphp
                                <span class="text-xs font-semibold {{ $classColor }} px-2 py-1 rounded-lg">
                                    {{ $className }}
                                </span>
                            @else
                                <span class="text-xs text-slate-300">—</span>
                            @endif
                        </td>

                        <td class="px-6 py-3 align-middle">
                            @if($student->gender === 'male')
                                <span class="text-xs font-semibold bg-blue-50 text-blue-500 px-2 py-1 rounded-full">
                                    <i class="fa fa-mars mr-1 text-xs"></i> Male
                                </span>
                            @elseif($student->gender === 'female')
                                <span class="text-xs font-semibold bg-pink-50 text-pink-500 px-2 py-1 rounded-full">
                                    <i class="fa fa-venus mr-1 text-xs"></i> Female
                                </span>
                            @else
                                <span class="text-xs text-slate-300">—</span>
                            @endif
                        </td>

                        <td class="px-6 py-3 align-middle">
                            @if($student->teacher)
                                <div class="flex items-center gap-2">
                                    <div class="w-6 h-6 rounded-lg bg-gradient-to-tl from-green-500 to-emerald-400 flex items-center justify-center text-white text-xs font-bold flex-shrink-0">
                                        {{ strtoupper(substr($student->teacher->name, 0, 1)) }}
                                    </div>
                                    <span class="text-sm text-slate-600">{{ $student->teacher->name }}</span>
                                </div>
                            @else
                                <span class="text-xs text-slate-300 italic">Not assigned</span>
                            @endif
                        </td>

                        <td class="px-6 py-3 align-middle text-center">
                            <div class="flex items-center justify-center gap-2">
                                <a href="#"
                                   class="w-7 h-7 rounded-lg bg-blue-50 text-blue-500 flex items-center justify-center hover:bg-blue-100 transition-colors"
                                   title="View">
                                    <i class="fa fa-eye text-xs"></i>
                                </a>
                                <a href="{{ route('tenant.students.edit', [$subdomain, $student->id]) }}"
                                   class="w-7 h-7 rounded-lg bg-amber-50 text-amber-500 flex items-center justify-center hover:bg-amber-100 transition-colors"
                                   title="Edit">
                                    <i class="fa fa-pen text-xs"></i>
                                </a>
                                <form method="POST"
                                      action="{{ route('tenant.students.delete', [$subdomain, $student->id]) }}"
                                      onsubmit="return confirm('Delete {{ $student->name }}?')"
                                      class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="w-7 h-7 rounded-lg bg-red-50 text-red-500 flex items-center justify-center hover:bg-red-100 transition-colors"
                                            title="Delete">
                                        <i class="fa fa-trash text-xs"></i>
                                    </button>
                                </form>
                            </div>
                        </td>

                    </tr>
                    @empty
<tr>
    <td colspan="7" class="px-6 py-12 text-center">
        <div class="flex flex-col items-center">
            <div class="w-16 h-16 rounded-2xl bg-gray-100 flex items-center justify-center mb-4">
                <i class="fa fa-user-graduate text-gray-400 text-2xl"></i>
            </div>
            @if(request('class_id') || request('classFilter'))
                <p class="text-slate-500 font-semibold">No students in this class</p>
                <p class="text-slate-400 text-sm mt-1">This class has no enrolled students yet</p>
            @else
                <p class="text-slate-500 font-semibold">No students found</p>
                <p class="text-slate-400 text-sm mt-1">Add your first student to get started</p>
            @endif
            <a href="{{ route('tenant.students.create', $subdomain) }}"
               class="mt-4 px-4 py-2 text-sm text-white rounded-lg bg-gradient-to-tl from-gray-900 to-slate-700">
                + Add Student
            </a>
        </div>
    </td>
</tr>
                    @endforelse

                </tbody>
            </table>
        </div>

        {{-- Pagination Footer --}}
        <div class="flex items-center justify-between px-6 py-4 border-t border-gray-100">
            <p class="text-xs text-slate-400">
                Showing
                <span class="font-semibold text-slate-600">{{ $students->firstItem() }}–{{ $students->lastItem() }}</span>
                of
                <span class="font-semibold text-slate-600">{{ $students->total() }}</span>
                {{ Str::plural('student', $students->total()) }}
            </p>
            <div>{{ $students->links() }}</div>
        </div>

    </div>

</div>

{{-- ═══════════════════════════════════════════
     HIDDEN PRINT SECTION
═══════════════════════════════════════════ --}}
<div id="studentPrintArea" style="display:none">
    <style>
        @media print {
            body * { visibility: hidden; }
            #studentPrintArea, #studentPrintArea * { visibility: visible; }
            #studentPrintArea { position: absolute; inset: 0; padding: 20px; }
        }
        .s-print-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 16px;
            font-family: Arial, sans-serif;
        }
        .s-login-card {
            border: 1.5px solid #cbd5e1;
            border-radius: 10px;
            padding: 16px 20px;
            page-break-inside: avoid;
            background: #fff;
        }
        .s-login-card .s-header {
            display: flex; align-items: center; gap: 10px;
            border-bottom: 1px solid #e2e8f0;
            padding-bottom: 10px; margin-bottom: 12px;
        }
        .s-login-card .s-avatar {
            width: 38px; height: 38px; border-radius: 8px;
            display: flex; align-items: center; justify-content: center;
            color: #fff; font-weight: bold; font-size: 14px; flex-shrink: 0;
        }
        .s-avatar.male   { background: linear-gradient(135deg, #3b82f6, #6366f1); }
        .s-avatar.female { background: linear-gradient(135deg, #ec4899, #f43f5e); }
        .s-login-card .s-name  { font-size: 11px; font-weight: bold; color: #1e293b; }
        .s-login-card .s-sub   { font-size: 10px; color: #64748b; }
        .s-login-card .s-field { margin-bottom: 7px; }
        .s-login-card .s-field label {
            display: block; font-size: 9px; font-weight: bold;
            text-transform: uppercase; color: #94a3b8; letter-spacing: 0.05em; margin-bottom: 2px;
        }
        .s-login-card .s-field span { font-size: 12px; color: #1e293b; font-weight: 600; }
        .s-login-card .s-field.s-password span { font-size: 13px; color: #2563eb; letter-spacing: 0.05em; }
        .s-login-card .s-url {
            margin-top: 10px; padding-top: 10px;
            border-top: 1px dashed #e2e8f0;
            font-size: 10px; color: #64748b;
        }
        .s-login-card .s-url strong { color: #1e293b; }
        .s-print-title { text-align: center; margin-bottom: 20px; font-family: Arial, sans-serif; }
        .s-print-title h2 { font-size: 18px; color: #1e293b; margin: 0; }
        .s-print-title p  { font-size: 11px; color: #64748b; margin: 4px 0 0; }
        .s-badge {
            display: inline-block; font-size: 9px; font-weight: bold;
            padding: 2px 8px; border-radius: 20px; margin-left: 6px;
        }
        .s-badge.male   { background: #dbeafe; color: #1d4ed8; }
        .s-badge.female { background: #fce7f3; color: #be185d; }
    </style>

    <div class="s-print-title">
        <h2>Student Login Credentials</h2>
        <p>Confidential — Please hand directly to each student &nbsp;|&nbsp; Printed: <span id="studentPrintDate"></span></p>
    </div>

    <div class="s-print-grid">
        @foreach($students as $student)
        @php $g = $student->gender ?? 'male'; @endphp
        <div class="s-login-card">
            <div class="s-header">
                <div class="s-avatar {{ $g }}">{{ strtoupper(substr($student->name, 0, 2)) }}</div>
                <div>
                    <div class="s-name">
                        {{ $student->name }}
                        <span class="s-badge {{ $g }}">{{ ucfirst($g) }}</span>
                    </div>
                    <div class="s-sub">
                        {{ $student->schoolClass->name ?? 'No class' }}
                        &nbsp;·&nbsp;
                        {{ $student->student_id }}
                    </div>
                </div>
            </div>

            <div class="s-field">
                <label>Full Name</label>
                <span>{{ $student->name }}</span>
            </div>
            <div class="s-field">
                <label>Login Email</label>
                <span>{{ $student->email ?? '(no email)' }}</span>
            </div>
            <div class="s-field s-password">
                <label>Password</label>
                <span>{{ $student->plain_password ?? '(not stored)' }}</span>
            </div>
            <div class="s-field">
                <label>Class &nbsp;/&nbsp; Teacher</label>
                <span>{{ $student->schoolClass->name ?? '—' }} &nbsp;/&nbsp; {{ $student->teacher->name ?? '—' }}</span>
            </div>
            <div class="s-url">
                <strong>Login URL:</strong> {{ request()->getSchemeAndHttpHost() }}/student/login
            </div>
        </div>
        @endforeach
    </div>
</div>

<script>
// ── Print Function ──
function printStudentCards() {
    document.getElementById('studentPrintDate').textContent = new Date().toLocaleDateString('en-GB', {
        day: '2-digit', month: 'long', year: 'numeric'
    });
    const area = document.getElementById('studentPrintArea');
    area.style.display = 'block';
    window.print();
    area.style.display = 'none';
}

// ── AJAX Pagination Function ──
function loadStudentsPage(url) {
    const wrapper = document.getElementById('studentsWrapper');
    if (!wrapper) return;

    const overlay = document.createElement('div');
    overlay.id = 'studentsLoadingOverlay';
    overlay.style.cssText = `
        position:absolute; inset:0; background:rgba(255,255,255,0.75);
        display:flex; flex-direction:column; align-items:center; justify-content:center;
        z-index:10; border-radius:1rem; gap:10px;
    `;
    overlay.innerHTML = `
        <div style="width:36px;height:36px;border:3px solid #e2e8f0;border-top-color:#3b82f6;border-radius:50%;animation:studentSpin 0.7s linear infinite;"></div>
        <span style="font-size:12px;font-weight:600;color:#94a3b8;letter-spacing:0.05em;">Loading...</span>
    `;
    wrapper.style.position = 'relative';
    wrapper.appendChild(overlay);
    wrapper.style.pointerEvents = 'none';

    fetch(url, {
        headers: { 'X-Requested-With': 'XMLHttpRequest' },
        credentials: 'same-origin'
    })
    .then(r => { if (!r.ok) throw new Error('error'); return r.text(); })
    .then(html => {
        const tmp = document.createElement('div');
        tmp.innerHTML = html;
        const newWrapper = tmp.querySelector('#studentsWrapper');
        if (newWrapper) wrapper.innerHTML = newWrapper.innerHTML;
        window.history.pushState({}, '', url);
        wrapper.style.pointerEvents = '';
        wrapper.scrollIntoView({ behavior: 'smooth', block: 'start' });
    })
    .catch(() => {
        wrapper.style.pointerEvents = '';
        window.location.href = url;
    });
}

// ✅ ONLY intercept pagination links (links with 'page=' parameter)
document.addEventListener('click', function(e) {
    const link = e.target.closest('a');
    if (!link) return;
    if (!link.closest('#studentsWrapper')) return;
    if (!link.href || link.href === '#' || link.href === window.location.href) return;
    
    // ✅ Check if it's a pagination link (contains 'page=' parameter)
    const url = new URL(link.href);
    if (url.searchParams.has('page')) {
        e.preventDefault();
        e.stopPropagation();
        loadStudentsPage(link.href);
    }
    // ✅ Otherwise, let normal navigation happen (edit, view, delete, add)
});

window.addEventListener('popstate', () => location.reload());

// ── Client-side filter (current page only) ──
function filterTable() {
    const searchTerm   = document.getElementById('searchInput').value.toLowerCase();
    const selectedClass = document.getElementById('classFilter').value;
    const rows = document.querySelectorAll('#studentsTable tbody tr');

    rows.forEach(row => {
        const name      = row.querySelector('td:nth-child(2)')?.innerText.toLowerCase() ?? '';
        const id        = row.querySelector('td:nth-child(3)')?.innerText.toLowerCase() ?? '';
        const className = row.querySelector('td:nth-child(4)')?.innerText.trim() ?? '';
        const gender    = row.querySelector('td:nth-child(5)')?.innerText.toLowerCase() ?? '';

        const matchSearch = searchTerm === '' || name.includes(searchTerm) || id.includes(searchTerm) || gender.includes(searchTerm);
        const matchClass  = selectedClass === '' || className === selectedClass;

        row.style.display = (matchSearch && matchClass) ? '' : 'none';
    });

    // Show "no students in this class" message when filter hides all rows
    const visibleRows = [...rows].filter(r => r.style.display !== 'none');
    let noResultMsg = document.getElementById('noStudentMsg');

    if (visibleRows.length === 0 && rows.length > 0) {
        if (!noResultMsg) {
            noResultMsg = document.createElement('tr');
            noResultMsg.id = 'noStudentMsg';
            noResultMsg.innerHTML = `
                <td colspan="7" class="px-6 py-10 text-center">
                    <div class="flex flex-col items-center">
                        <div class="w-14 h-14 rounded-2xl bg-gray-100 flex items-center justify-center mb-3">
                            <i class="fa fa-user-graduate text-gray-400 text-2xl"></i>
                        </div>
                        <p class="text-slate-500 font-semibold">
                            ${selectedClass ? 'No students in this class' : 'No students match your search'}
                        </p>
                        <p class="text-slate-400 text-xs mt-1">
                            ${selectedClass ? 'This class has no enrolled students yet' : 'Try a different name or ID'}
                        </p>
                    </div>
                </td>`;
            document.querySelector('#studentsTable tbody').appendChild(noResultMsg);
        }
    } else {
        if (noResultMsg) noResultMsg.remove();
    }
}
</script>

<style>
@keyframes studentSpin {
    0%   { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}
#studentsWrapper { position: relative; }
</style>

@endsection