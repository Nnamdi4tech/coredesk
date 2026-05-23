@extends('layouts.admin')

@section('content')

@php
    $subdomain = request()->route('subdomain');
@endphp

<div class="w-full px-6 py-6 mx-auto">

    {{-- ═══════════════════════════════════════════
         PAGE HEADER
    ═══════════════════════════════════════════ --}}
    <div class="flex flex-wrap items-center justify-between mb-6 -mx-3">
        <div class="px-3">
            <h3 class="text-2xl font-bold text-slate-700 mb-1">Staff / Teachers</h3>
            <p class="text-sm text-slate-400">
                <i class="fa fa-home mr-1"></i> Dashboard
                <span class="mx-1 text-slate-300">/</span>
                <span class="text-slate-600">Teachers Management</span>
            </p>
        </div>
        <div class="px-3 flex gap-3 mt-3 md:mt-0">
            <button onclick="printCredentials()"
              class="px-5 py-2 text-sm font-semibold text-white rounded-lg bg-gradient-to-tl from-green-600 to-emerald-500 shadow-soft-md hover:shadow-soft-xl transition-all hover:scale-105">
              <i class="fa fa-print mr-1"></i> Print Login Cards
            </button>
            
            <a href="{{ route('tenant.teachers.create', $subdomain) }}"
               class="px-5 py-2 text-sm font-semibold text-white rounded-lg bg-gradient-to-tl from-gray-900 to-slate-700 shadow-soft-md hover:shadow-soft-xl transition-all hover:scale-105">
                <i class="fa fa-user-plus mr-1"></i> Add Staff
            </a>
        </div>

        
    </div>

    <!-- new grid start here -->

    {{-- SUCCESS MESSAGE --}}
@if(session('success'))
    <div class="p-4 mb-6 text-sm text-green-700 bg-green-50 border border-green-200 rounded-2xl flex items-center gap-3">
        <div class="w-8 h-8 rounded-lg bg-gradient-to-tl from-green-500 to-emerald-400 flex items-center justify-center flex-shrink-0">
            <i class="fa fa-check-circle text-black text-xs"></i>
        </div>
        <p class="font-semibold">{{ session('success') }}</p>
        <button onclick="this.parentElement.remove()" class="ml-auto text-green-400 hover:text-green-600">
            <i class="fa fa-times text-black text-xs"></i>
        </button>
    </div>
@endif

{{-- ERROR MESSAGE --}}
@if(session('error'))
    <div class="p-4 mb-6 text-sm text-red-700 bg-red-50 border border-red-200 rounded-2xl flex items-center gap-3">
        <div class="w-8 h-8 rounded-lg bg-gradient-to-tl from-red-500 to-rose-400 flex items-center justify-center flex-shrink-0">
            <i class="fa fa-exclamation-circle text-black text-xs"></i>
        </div>
        <p class="font-semibold">{{ session('error') }}</p>
        <button onclick="this.parentElement.remove()" class="ml-auto text-red-400 hover:text-red-600">
            <i class="fa fa-times text-black text-xs"></i>
        </button>
    </div>
@endif
     
        {{-- STAT CARDS — 4 PER ROW using your pattern --}}
<div class="flex flex-wrap -mx-3 mb-6">
    <!-- card1 - Total Teachers -->
<div class="w-full max-w-full px-3 mb-6 sm:w-1/2 sm:flex-none xl:mb-0 xl:w-1/4">
    <div class="relative flex flex-col min-w-0 break-words bg-white shadow-soft-xl rounded-2xl bg-clip-border">
        <div class="flex-auto p-4">
            <div class="flex flex-row -mx-3">
                <div class="flex-none w-2/3 max-w-full px-3">
                    <div>
                        <p class="mb-0 font-sans text-sm font-semibold leading-normal">Total Teachers</p>
                        <h5 class="mb-0 font-bold">
                            {{ $totalTeachers }}
                            <span class="text-sm leading-normal font-weight-bolder text-lime-500">{{ $totalTeachers > 0 ? '+' . $totalTeachers : '0' }}</span>
                        </h5>
                    </div>
                </div>
                <div class="px-3 text-right basis-1/3">
                    <div class="inline-block w-12 h-12 text-center rounded-lg bg-gradient-to-tl from-blue-500 to-cyan-400">
                        <i class="fa fa-users text-lg relative text-info top-3.5"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- card2 - Active Teachers -->
<div class="w-full max-w-full px-3 mb-6 sm:w-1/2 sm:flex-none xl:mb-0 xl:w-1/4">
    <div class="relative flex flex-col min-w-0 break-words bg-white shadow-soft-xl rounded-2xl bg-clip-border">
        <div class="flex-auto p-4">
            <div class="flex flex-row -mx-3">
                <div class="flex-none w-2/3 max-w-full px-3">
                    <div>
                        <p class="mb-0 font-sans text-sm font-semibold leading-normal">Active Teachers</p>
                        <h5 class="mb-0 font-bold">
                            {{ $activeTeachers }}
                            <span class="text-sm leading-normal font-weight-bolder text-lime-500">{{ $activePercentage }}%</span>
                        </h5>
                    </div>
                </div>
                <div class="px-3 text-right basis-1/3">
                    <div class="inline-block w-12 h-12 text-center rounded-lg bg-gradient-to-tl from-green-500 to-emerald-400">
                        <i class="fa fa-user-check text-lg relative text-primary top-3.5"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- card3 - On Leave -->
<div class="w-full max-w-full px-3 mb-6 sm:w-1/2 sm:flex-none xl:mb-0 xl:w-1/4">
    <div class="relative flex flex-col min-w-0 break-words bg-white shadow-soft-xl rounded-2xl bg-clip-border">
        <div class="flex-auto p-4">
            <div class="flex flex-row -mx-3">
                <div class="flex-none w-2/3 max-w-full px-3">
                    <div>
                        <p class="mb-0 font-sans text-sm font-semibold leading-normal">On Leave</p>
                        <h5 class="mb-0 font-bold">
                            {{ $onLeaveTeachers }}
                            <span class="text-sm leading-normal font-weight-bolder text-orange-500">{{ $onLeavePercentage }}%</span>
                        </h5>
                    </div>
                </div>
                <div class="px-3 text-right basis-1/3">
                    <div class="inline-block w-12 h-12 text-center rounded-lg bg-gradient-to-tl from-orange-500 to-yellow-400">
                        <i class="fa fa-calendar-times text-lg relative text-black top-3.5"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- card4 - Departments -->
<div class="w-full max-w-full px-3 sm:w-1/2 sm:flex-none xl:w-1/4">
    <div class="relative flex flex-col min-w-0 break-words bg-white shadow-soft-xl rounded-2xl bg-clip-border">
        <div class="flex-auto p-4">
            <div class="flex flex-row -mx-3">
                <div class="flex-none w-2/3 max-w-full px-3">
                    <div>
                        <p class="mb-0 font-sans text-sm font-semibold leading-normal">Departments</p>
                        <h5 class="mb-0 font-bold">
                            {{ $uniqueDepartments }}
                            <span class="text-sm leading-normal font-weight-bolder text-purple-500">{{ $uniqueDepartments }} dept{{ $uniqueDepartments != 1 ? 's' : '' }}</span>
                        </h5>
                    </div>
                </div>
                <div class="px-3 text-right basis-1/3">
                    <div class="inline-block w-12 h-12 text-center rounded-lg bg-gradient-to-tl from-purple-600 to-pink-500">
                        <i class="fa fa-layer-group text-lg relative text-primary top-3.5"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

</div>

{{-- STAT CARDS ROW 2 — 4 PER ROW --}}
<div class="flex flex-wrap -mx-3 mb-6">

    <!-- card5 - New This Month -->
<div class="w-full max-w-full px-3 mb-6 sm:w-1/2 sm:flex-none xl:mb-0 xl:w-1/4">
    <div class="relative flex flex-col min-w-0 break-words bg-white shadow-soft-xl rounded-2xl bg-clip-border">
        <div class="flex-auto p-4">
            <div class="flex flex-row -mx-3">
                <div class="flex-none w-2/3 max-w-full px-3">
                    <div>
                        <p class="mb-0 font-sans text-sm font-semibold leading-normal">New This Month</p>
                        <h5 class="mb-0 font-bold">
                            {{ $newThisMonth }}
                            <span class="text-sm leading-normal font-weight-bolder text-red-500">this mo.</span>
                        </h5>
                    </div>
                </div>
                <div class="px-3 text-right basis-1/3">
                    <div class="inline-block w-12 h-12 text-center rounded-lg bg-gradient-to-tl from-red-500 to-rose-400">
                        <i class="fa fa-user-plus text-lg relative top-3.5 text-white"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- card6 - Avg Performance -->
<div class="w-full max-w-full px-3 mb-6 sm:w-1/2 sm:flex-none xl:mb-0 xl:w-1/4">
    <div class="relative flex flex-col min-w-0 break-words bg-white shadow-soft-xl rounded-2xl bg-clip-border">
        <div class="flex-auto p-4">
            <div class="flex flex-row -mx-3">
                <div class="flex-none w-2/3 max-w-full px-3">
                    <div>
                        <p class="mb-0 font-sans text-sm font-semibold leading-normal">Avg Performance</p>
                        <h5 class="mb-0 font-bold">
                            {{ $avgPerformance }}%
                            <span class="text-sm leading-normal font-weight-bolder text-slate-500">avg</span>
                        </h5>
                    </div>
                </div>
                <div class="px-3 text-right basis-1/3">
                    <div class="inline-block w-12 h-12 text-center rounded-lg bg-gradient-to-tl from-slate-600 to-slate-400">
                        <i class="fa fa-chart-bar text-lg relative top-3.5 text-white"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- card7 - Subjects Taught -->
<div class="w-full max-w-full px-3 mb-6 sm:w-1/2 sm:flex-none xl:mb-0 xl:w-1/4">
    <div class="relative flex flex-col min-w-0 break-words bg-white shadow-soft-xl rounded-2xl bg-clip-border">
        <div class="flex-auto p-4">
            <div class="flex flex-row -mx-3">
                <div class="flex-none w-2/3 max-w-full px-3">
                    <div>
                        <p class="mb-0 font-sans text-sm font-semibold leading-normal">Subjects Taught</p>
                        <h5 class="mb-0 font-bold">
                            {{ $subjectsTaught }}
                            <span class="text-sm leading-normal font-weight-bolder text-teal-500">subjects</span>
                        </h5>
                    </div>
                </div>
                <div class="px-3 text-right basis-1/3">
                    <div class="inline-block w-12 h-12 text-center rounded-lg bg-gradient-to-tl from-teal-500 to-green-400">
                        <i class="fa fa-book-open text-lg relative top-3.5 text-primary"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- card8 - Classes Assigned -->
<div class="w-full max-w-full px-3 sm:w-1/2 sm:flex-none xl:w-1/4">
    <div class="relative flex flex-col min-w-0 break-words bg-white shadow-soft-xl rounded-2xl bg-clip-border">
        <div class="flex-auto p-4">
            <div class="flex flex-row -mx-3">
                <div class="flex-none w-2/3 max-w-full px-3">
                    <div>
                        <p class="mb-0 font-sans text-sm font-semibold leading-normal">Classes Assigned</p>
                        <h5 class="mb-0 font-bold">
                            {{ $classesAssigned }}
                            <span class="text-sm leading-normal font-weight-bolder text-indigo-500">classes</span>
                        </h5>
                    </div>
                </div>
                <div class="px-3 text-right basis-1/3">
                    <div class="inline-block w-12 h-12 text-center rounded-lg bg-gradient-to-tl from-indigo-500 to-blue-400">
                        <i class="fa fa-chalkboard text-lg relative top-3.5 text-primary"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
<!-- first cards ends here -->

    <!-- ends here -->
    {{-- ═══════════════════════════════════════════
         TEACHERS TABLE
    ═══════════════════════════════════════════ --}}
    <div id="teachersWrapper" class="bg-white rounded-2xl shadow-soft-xl overflow-hidden">

        {{-- Table Header --}}
        <div class="flex flex-wrap items-center justify-between px-6 py-4 border-b border-gray-100 gap-3">
            <div>
                <h6 class="font-bold text-slate-700">All Teachers</h6>
                <p class="text-xs text-slate-400 mt-0.5">
                  {{ $teachers->total() }} teacher{{ $teachers->total() != 1 ? 's' : '' }} total
                </p>
            </div>
            <div class="flex items-center gap-3">
                {{-- Search --}}
                <div class="relative">
                    <i class="fa fa-search absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-xs"></i>
                    <input type="text"
                           placeholder="Search teachers..."
                           class="pl-8 pr-4 py-2 text-sm border border-gray-200 rounded-lg focus:outline-none focus:border-fuchsia-300 w-52" />
                </div>
                {{-- Filter --}}
                <select class="px-3 py-2 text-sm border border-gray-200 rounded-lg focus:outline-none focus:border-fuchsia-300 text-slate-500">
                    <option>All Departments</option>
                    <option>Science</option>
                    <option>Mathematics</option>
                    <option>English</option>
                    <option>Arts</option>
                </select>
            </div>
        </div>

        {{-- Table --}}
        <div class="overflow-x-auto">
            <table class="items-center w-full mb-0 align-top border-gray-200 text-slate-500">
                <thead class="align-bottom bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xxs font-bold uppercase tracking-wider text-slate-400 opacity-70">Teacher</th>
                        <th class="px-6 py-3 text-left text-xxs font-bold uppercase tracking-wider text-slate-400 opacity-70">Staff ID</th>
                        <th class="px-6 py-3 text-left text-xxs font-bold uppercase tracking-wider text-slate-400 opacity-70">Department</th>
                        <th class="px-6 py-3 text-left text-xxs font-bold uppercase tracking-wider text-slate-400 opacity-70">Subject</th>
                        <th class="px-6 py-3 text-left text-xxs font-bold uppercase tracking-wider text-slate-400 opacity-70">Classes</th>
                        <th class="px-6 py-3 text-center text-xxs font-bold uppercase tracking-wider text-slate-400 opacity-70">Status</th>
                        <th class="px-6 py-3 text-center text-xxs font-bold uppercase tracking-wider text-slate-400 opacity-70">Actions</th>
                    </tr>
                </thead>
                <tbody>

    @forelse($teachers as $teacher)
    <tr class="border-t border-gray-100 hover:bg-gray-50 transition-colors">

        {{-- Teacher Name + Email --}}
        <td class="px-6 py-3 align-middle">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 rounded-xl bg-gradient-to-tl from-blue-500 to-cyan-400 flex items-center justify-center text-primary text-sm font-bold shadow-soft-md flex-shrink-0">
                    {{ strtoupper(substr($teacher->name, 0, 2)) }}
                </div>
                <div>
                    <p class="text-sm font-semibold text-slate-700 mb-0">{{ $teacher->name }}</p>
                    <p class="text-xs text-slate-400">{{ $teacher->email ?? '—' }}</p>
                </div>
            </div>
        </td>

        {{-- Staff ID --}}
        <td class="px-6 py-3 align-middle">
            <span class="text-xs font-mono text-slate-500">{{ $teacher->staff_id }}</span>
        </td>

        {{-- Department --}}
        <td class="px-6 py-3 align-middle">
            @if($teacher->department)
                @php
                    $deptColors = [
                        'Science'        => 'bg-blue-50 text-blue-600',
                        'Mathematics'    => 'bg-purple-50 text-purple-600',
                        'English'        => 'bg-orange-50 text-orange-600',
                        'Arts'           => 'bg-pink-50 text-pink-600',
                        'Social Studies' => 'bg-teal-50 text-teal-600',
                        'Technical'      => 'bg-gray-100 text-gray-600',
                    ];
                    $deptColor = $deptColors[$teacher->department] ?? 'bg-slate-100 text-slate-600';
                @endphp
                <span class="text-xs font-semibold {{ $deptColor }} px-2 py-1 rounded-lg">
                    {{ $teacher->department }}
                </span>
            @else
                <span class="text-xs text-slate-300">—</span>
            @endif
        </td>

        {{-- Subject --}}
        <td class="px-6 py-3 align-middle text-sm text-slate-600">
            {{ $teacher->subject ?? '—' }}
        </td>

        {{-- Classes --}}
<td class="px-6 py-3 align-middle">
    @php $assignedClasses = $teacher->assigned_classes; @endphp
    @if($assignedClasses && $assignedClasses !== 'Not assigned')
        <div class="flex flex-wrap gap-1 max-h-16 overflow-y-auto">
            @foreach(explode(', ', $assignedClasses) as $class)
                <span class="text-xs font-semibold bg-indigo-50 text-indigo-600 px-2 py-1 rounded-lg whitespace-nowrap">
                    {{ trim($class) }}
                </span>
            @endforeach
        </div>
    @else
        <span class="text-xs text-slate-300 italic">Not assigned</span>
    @endif
</td>

        {{-- Status --}}
        <td class="px-6 py-3 align-middle text-center">
            @php
                $s = $teacher->status ?? 'active';
                $statusStyles = [
                    'active'    => ['bg' => 'bg-green-50 text-green-600',   'dot' => 'text-green-400',  'label' => 'Active'],
                    'inactive'  => ['bg' => 'bg-gray-100 text-gray-500',    'dot' => 'text-gray-400',   'label' => 'Inactive'],
                    'on_leave'  => ['bg' => 'bg-orange-50 text-orange-500', 'dot' => 'text-orange-400', 'label' => 'On Leave'],
                    'suspended' => ['bg' => 'bg-red-50 text-red-500',       'dot' => 'text-red-400',    'label' => 'Suspended'],
                ];
                $style = $statusStyles[$s] ?? $statusStyles['active'];
            @endphp
            <span class="text-xs font-semibold {{ $style['bg'] }} px-3 py-1 rounded-full">
                <i class="fa fa-circle {{ $style['dot'] }} mr-1" style="font-size:6px;vertical-align:middle"></i>
                {{ $style['label'] }}
            </span>
        </td>

        {{-- Actions --}}
        <td class="px-6 py-3 align-middle text-center">
            <div class="flex items-center justify-center gap-2">
                <a href="#"
                   class="w-7 h-7 rounded-lg bg-blue-50 text-blue-500 flex items-center justify-center hover:bg-blue-100 transition-colors"
                   title="View">
                    <i class="fa fa-eye text-xs"></i>
                </a>
                <a href="{{ route('tenant.teachers.edit', [$subdomain, $teacher->id]) }}"
                   class="w-7 h-7 rounded-lg bg-amber-50 text-amber-500 flex items-center justify-center hover:bg-amber-100 transition-colors"
                   title="Edit">
                    <i class="fa fa-pen text-xs"></i>
                </a>
                <form method="POST"
      action="{{ route('tenant.teachers.delete', [$subdomain, $teacher->id]) }}"
      onsubmit="return confirm('Delete {{ $teacher->name }}?')"
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

    {{-- Empty State --}}
    <tr>
        <td colspan="7" class="px-6 py-12 text-center">
            <div class="flex flex-col items-center">
                <div class="w-16 h-16 rounded-2xl bg-gray-100 flex items-center justify-center mb-4">
                    <i class="fa fa-users text-gray-400 text-2xl"></i>
                </div>
                <p class="text-slate-500 font-semibold">No teachers found</p>
                <p class="text-slate-400 text-sm mt-1">Add your first teacher to get started</p>
                <a href="{{ route('tenant.teachers.create', $subdomain) }}"
                   class="mt-4 px-4 py-2 text-sm text-white rounded-lg bg-gradient-to-tl from-gray-900 to-slate-700">
                    + Add Teacher
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
        <span class="font-semibold text-slate-600">{{ $teachers->firstItem() }}–{{ $teachers->lastItem() }}</span> 
        of 
        <span class="font-semibold text-slate-600">{{ $teachers->total() }}</span> 
        teachers
    </p>
    <div>
        {{ $teachers->links() }}
    </div>
</div>
        

    </div>

</div>

{{-- HIDDEN PRINT SECTION --}}
<div id="printArea" style="display:none">
    <style>
        @media print {
            body * { visibility: hidden; }
            #printArea, #printArea * { visibility: visible; }
            #printArea { position: absolute; inset: 0; padding: 20px; }
        }
        .print-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 16px;
            font-family: Arial, sans-serif;
        }
        .login-card {
            border: 1.5px solid #cbd5e1;
            border-radius: 10px;
            padding: 16px 20px;
            page-break-inside: avoid;
            background: #fff;
        }
        .login-card .school-header {
            display: flex;
            align-items: center;
            gap: 10px;
            border-bottom: 1px solid #e2e8f0;
            padding-bottom: 10px;
            margin-bottom: 12px;
        }
        .login-card .avatar {
            width: 38px; height: 38px;
            background: linear-gradient(135deg, #3b82f6, #06b6d4);
            border-radius: 8px;
            display: flex; align-items: center; justify-content: center;
            color: #fff; font-weight: bold; font-size: 14px; flex-shrink: 0;
        }
        .login-card .school-name {
            font-size: 11px; font-weight: bold; color: #1e293b; line-height: 1.3;
        }
        .login-card .school-sub {
            font-size: 10px; color: #64748b;
        }
        .login-card .field { margin-bottom: 7px; }
        .login-card .field label {
            display: block; font-size: 9px; font-weight: bold;
            text-transform: uppercase; color: #94a3b8; letter-spacing: 0.05em; margin-bottom: 2px;
        }
        .login-card .field span {
            font-size: 12px; color: #1e293b; font-weight: 600;
        }
        .login-card .field.password span {
            font-size: 13px; color: #2563eb; letter-spacing: 0.05em;
        }
        .login-card .url-row {
            margin-top: 10px; padding-top: 10px;
            border-top: 1px dashed #e2e8f0;
            font-size: 10px; color: #64748b;
        }
        .login-card .url-row strong { color: #1e293b; }
        .print-title {
            text-align: center; margin-bottom: 20px;
        }
        .print-title h2 { font-size: 18px; color: #1e293b; margin: 0; }
        .print-title p { font-size: 11px; color: #64748b; margin: 4px 0 0; }
        .status-badge {
            display: inline-block; font-size: 9px; font-weight: bold;
            padding: 2px 8px; border-radius: 20px; margin-left: 6px;
            background: #dcfce7; color: #16a34a;
        }
    </style>

    <div class="print-title">
        <h2>Staff Login Credentials</h2>
        <p>Confidential — Please hand directly to each staff member &nbsp;|&nbsp; Printed: <span id="printDate"></span></p>
    </div>

    <div class="print-grid">
        @foreach($teachers as $teacher)
        <div class="login-card">
            <div class="school-header">
                <div class="avatar">{{ strtoupper(substr($teacher->name, 0, 2)) }}</div>
                <div>
                    <div class="school-name">{{ $teacher->name }} <span class="status-badge">{{ ucfirst(str_replace('_',' ',$teacher->status ?? 'active')) }}</span></div>
                    <div class="school-sub">{{ $teacher->department ?? 'No department' }} &nbsp;·&nbsp; {{ $teacher->staff_id }}</div>
                </div>
            </div>

            <div class="field">
                <label>Full Name</label>
                <span>{{ $teacher->name }}</span>
            </div>
            <div class="field">
                <label>Login Email</label>
                <span>{{ $teacher->email }}</span>
            </div>
            <div class="field password">
                <label>Password</label>
                <span>{{ $teacher->plain_password ?? '(password not stored)' }}</span>
            </div>
            <div class="field">
                <label>Subject &nbsp;/&nbsp; Position</label>
                <span>{{ $teacher->subject ?? '—' }} &nbsp;/&nbsp; {{ $teacher->position ?? 'Teacher' }}</span>
            </div>
            <div class="url-row">
                <strong>Login URL:</strong> {{ request()->getSchemeAndHttpHost() }}
            </div>
        </div>
        @endforeach
    </div>
</div>

<script>
function printCredentials() {
    document.getElementById('printDate').textContent = new Date().toLocaleDateString('en-GB', {
        day: '2-digit', month: 'long', year: 'numeric'
    });
    const printArea = document.getElementById('printArea');
    printArea.style.display = 'block';
    window.print();
    printArea.style.display = 'none';
}
</script>

<script>
function loadTeachersPage(url) {
    const wrapper = document.getElementById('teachersWrapper');
    if (!wrapper) return;

    const overlay = document.createElement('div');
    overlay.id = 'teachersLoadingOverlay';
    overlay.style.cssText = `
        position:absolute; inset:0; background:rgba(255,255,255,0.75);
        display:flex; flex-direction:column; align-items:center; justify-content:center;
        z-index:10; border-radius:1rem; gap:10px;
    `;
    overlay.innerHTML = `
        <div style="width:36px;height:36px;border:3px solid #e2e8f0;border-top-color:#3b82f6;border-radius:50%;animation:teacherSpin 0.7s linear infinite;"></div>
        <span style="font-size:12px;font-weight:600;color:#94a3b8;letter-spacing:0.05em;">Loading...</span>
    `;
    wrapper.style.position = 'relative';
    wrapper.appendChild(overlay);
    wrapper.style.pointerEvents = 'none';

    fetch(url, {
        headers: { 'X-Requested-With': 'XMLHttpRequest' },
        credentials: 'same-origin'
    })
    .then(r => { if (!r.ok) throw new Error('Network error'); return r.text(); })
    .then(html => {
        const tmp = document.createElement('div');
        tmp.innerHTML = html;
        const newWrapper = tmp.querySelector('#teachersWrapper');
        if (newWrapper) {
            wrapper.innerHTML = newWrapper.innerHTML;
        }
        window.history.pushState({}, '', url);
        wrapper.style.pointerEvents = '';
    })
    .catch(() => {
        wrapper.style.pointerEvents = '';
        window.location.href = url;
    });
}

// ✅ ONLY intercept pagination links (links with 'page=' in URL)
document.addEventListener('click', function(e) {
    const link = e.target.closest('a');
    if (!link) return;
    if (!link.closest('#teachersWrapper')) return;
    if (!link.href || link.href === '#' || link.href === window.location.href) return;
    
    // ✅ Check if it's a pagination link (contains 'page=' parameter)
    const url = new URL(link.href);
    if (url.searchParams.has('page')) {
        e.preventDefault();
        e.stopPropagation();
        loadTeachersPage(link.href);
    }
    // ✅ Otherwise, let normal navigation happen (edit, add, view, delete)
});

window.addEventListener('popstate', () => location.reload());
</script>

<style>
@keyframes teacherSpin {
    0%  { transform: rotate(0deg); }
    100%{ transform: rotate(360deg); }
}
#teachersWrapper {
    position: relative;
    transition: opacity 0.2s ease;
}
</style>

@endsection