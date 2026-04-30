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
            <h3 class="text-2xl font-bold text-slate-700 mb-1">Teachers</h3>
            <p class="text-sm text-slate-400">
                <i class="fa fa-home mr-1"></i> Dashboard
                <span class="mx-1 text-slate-300">/</span>
                <span class="text-slate-600">Teachers Management</span>
            </p>
        </div>
        <div class="px-3 flex gap-3 mt-3 md:mt-0">
            <button class="px-4 py-2 text-sm border border-gray-300 rounded-lg text-slate-600 hover:bg-gray-50 transition-all">
                <i class="fa fa-file-export mr-1"></i> Export
            </button>
            <button class="px-4 py-2 text-sm border border-gray-300 rounded-lg text-slate-600 hover:bg-gray-50 transition-all">
                <i class="fa fa-file-import mr-1"></i> Import
            </button>
            <a href="{{ route('tenant.teachers.create', $subdomain) }}"
               class="px-5 py-2 text-sm font-semibold text-white rounded-lg bg-gradient-to-tl from-gray-900 to-slate-700 shadow-soft-md hover:shadow-soft-xl transition-all hover:scale-105">
                <i class="fa fa-plus mr-1"></i> Add Teacher
            </a>
        </div>
    </div>

    {{-- ═══════════════════════════════════════════
         STAT CARDS — 4 COLUMNS
    ═══════════════════════════════════════════ --}}
<div class="flex flex-wrap -mx-3 mb-6">

    {{-- LEFT GROUP: 6 cols --}}
    <div class="w-full px-3 lg:w-1/2">
        <div class="grid grid-cols-3 gap-4">

            {{-- Card 1: Total Teachers --}}
            <div class="relative flex flex-col min-w-0 break-words bg-white shadow-soft-xl rounded-2xl p-4 overflow-hidden">
                <div class="absolute top-0 right-0 w-20 h-20 rounded-full bg-gradient-to-tl from-blue-500 to-cyan-400 opacity-10 -mr-4 -mt-4"></div>
                <div class="flex items-center justify-between mb-3">
                    <div class="w-10 h-10 rounded-xl bg-gradient-to-tl from-blue-500 to-cyan-400 flex items-center justify-center shadow-soft-md">
                        <i class="fa fa-users  text-sm"></i>
                    </div>
                    <span class="text-xs font-semibold text-lime-500 bg-lime-50 px-2 py-0.5 rounded-full">+12%</span>
                </div>
                <h4 class="text-2xl font-bold text-slate-700">{{ $teachers->count() }}</h4>
                <!-- <p class="text-xs text-slate-400 mt-1">Total Teachers</p> -->
                <p class="text-xs text-slate-400 mt-0.5">
                 Total: <span class="font-semibold text-slate-600">{{ $teachers->count() }}</span>
                 {{ Str::plural('teacher', $teachers->count()) }}
                 </p>
            </div>

            {{-- Card 2: Active --}}
            <div class="relative flex flex-col min-w-0 break-words bg-white shadow-soft-xl rounded-2xl p-4 overflow-hidden">
                <div class="absolute top-0 right-0 w-20 h-20 rounded-full bg-gradient-to-tl from-green-500 to-emerald-400 opacity-10 -mr-4 -mt-4"></div>
                <div class="flex items-center justify-between mb-3">
                    <div class="w-10 h-10 rounded-xl bg-gradient-to-tl from-green-500 to-emerald-400 flex items-center justify-center shadow-soft-md">
                        <i class="fa fa-user-check  text-sm"></i>
                    </div>
                    <span class="text-xs font-semibold text-lime-500 bg-lime-50 px-2 py-0.5 rounded-full">+5%</span>
                </div>
                <h4 class="text-2xl font-bold text-slate-700">20</h4>
                <p class="text-xs text-slate-400 mt-1">Active Teachers</p>
                <div class="mt-3 h-1 bg-gray-100 rounded-full">
                    <div class="h-1 bg-gradient-to-r from-green-500 to-emerald-400 rounded-full" style="width: 83%"></div>
                </div>
            </div>

            {{-- Card 3: On Leave --}}
            <div class="relative flex flex-col min-w-0 break-words bg-white shadow-soft-xl rounded-2xl p-4 overflow-hidden">
                <div class="absolute top-0 right-0 w-20 h-20 rounded-full bg-gradient-to-tl from-orange-500 to-yellow-400 opacity-10 -mr-4 -mt-4"></div>
                <div class="flex items-center justify-between mb-3">
                    <div class="w-10 h-10 rounded-xl bg-gradient-to-tl from-orange-500 to-yellow-400 flex items-center justify-center shadow-soft-md">
                        <i class="fa fa-calendar-times  text-sm"></i>
                    </div>
                    <span class="text-xs font-semibold text-orange-500 bg-orange-50 px-2 py-0.5 rounded-full">2 now</span>
                </div>
                <h4 class="text-2xl font-bold text-slate-700">2</h4>
                <p class="text-xs text-slate-400 mt-1">On Leave</p>
                <div class="mt-3 h-1 bg-gray-100 rounded-full">
                    <div class="h-1 bg-gradient-to-r from-orange-500 to-yellow-400 rounded-full" style="width: 8%"></div>
                </div>
            </div>

        </div>
    </div>

    {{-- RIGHT GROUP: 6 cols --}}
    <div class="w-full px-3 mt-4 lg:mt-0 lg:w-1/2">
        <div class="grid grid-cols-3 gap-4">

            {{-- Card 4: Departments --}}
            <div class="relative flex flex-col min-w-0 break-words bg-white shadow-soft-xl rounded-2xl p-4 overflow-hidden">
                <div class="absolute top-0 right-0 w-20 h-20 rounded-full bg-gradient-to-tl from-purple-600 to-pink-500 opacity-10 -mr-4 -mt-4"></div>
                <div class="flex items-center justify-between mb-3">
                    <div class="w-10 h-10 rounded-xl bg-gradient-to-tl from-purple-600 to-pink-500 flex items-center justify-center shadow-soft-md">
                        <i class="fa fa-layer-group  text-sm"></i>
                    </div>
                    <span class="text-xs font-semibold text-purple-500 bg-purple-50 px-2 py-0.5 rounded-full">5 depts</span>
                </div>
                <h4 class="text-2xl font-bold text-slate-700">5</h4>
                <p class="text-xs text-slate-400 mt-1">Departments</p>
                <div class="mt-3 h-1 bg-gray-100 rounded-full">
                    <div class="h-1 bg-gradient-to-r from-purple-600 to-pink-500 rounded-full" style="width: 60%"></div>
                </div>
            </div>

            {{-- Card 5: New This Month --}}
            <div class="relative flex flex-col min-w-0 break-words bg-white shadow-soft-xl rounded-2xl p-4 overflow-hidden">
                <div class="absolute top-0 right-0 w-20 h-20 rounded-full bg-gradient-to-tl from-red-500 to-rose-400 opacity-10 -mr-4 -mt-4"></div>
                <div class="flex items-center justify-between mb-3">
                    <div class="w-10 h-10 rounded-xl bg-gradient-to-tl from-red-500 to-rose-400 flex items-center justify-center shadow-soft-md">
                        <i class="fa fa-user-plus  text-sm"></i>
                    </div>
                    <span class="text-xs font-semibold text-red-500 bg-red-50 px-2 py-0.5 rounded-full">this mo.</span>
                </div>
                <h4 class="text-2xl font-bold text-slate-700">3</h4>
                <p class="text-xs text-slate-400 mt-1">New This Month</p>
                <div class="mt-3 h-1 bg-gray-100 rounded-full">
                    <div class="h-1 bg-gradient-to-r from-red-500 to-rose-400 rounded-full" style="width: 30%"></div>
                </div>
            </div>

            {{-- Card 6: Avg Performance --}}
            <div class="relative flex flex-col min-w-0 break-words bg-white shadow-soft-xl rounded-2xl p-4 overflow-hidden">
                <div class="absolute top-0 right-0 w-20 h-20 rounded-full bg-gradient-to-tl from-slate-600 to-slate-400 opacity-10 -mr-4 -mt-4"></div>
                <div class="flex items-center justify-between mb-3">
                    <div class="w-10 h-10 rounded-xl bg-gradient-to-tl from-slate-600 to-slate-400 flex items-center justify-center shadow-soft-md">
                        <i class="fa fa-chart-bar  text-sm"></i>
                    </div>
                    <span class="text-xs font-semibold text-slate-500 bg-slate-100 px-2 py-0.5 rounded-full">avg</span>
                </div>
                <h4 class="text-2xl font-bold text-slate-700">87%</h4>
                <p class="text-xs text-slate-400 mt-1">Avg Performance</p>
                <div class="mt-3 h-1 bg-gray-100 rounded-full">
                    <div class="h-1 bg-gradient-to-r from-slate-600 to-slate-400 rounded-full" style="width: 87%"></div>
                </div>
            </div>

        </div>
    </div>

</div>

    {{-- ═══════════════════════════════════════════
         MODULE QUICK ACCESS — 6 COLUMNS
    ═══════════════════════════════════════════ --}}
    {{-- ═══════════════════════════════════════════
     MODULE QUICK ACCESS — GRID FORM
═══════════════════════════════════════════ --}}
<div class="mb-6">
    <h6 class="text-xs font-bold uppercase text-slate-400 tracking-widest mb-3 pl-1">
        Quick Access
    </h6>
    <div class="grid grid-cols-6 gap-4">

        {{-- Profile --}}
        <a href="#"
           class="group bg-white shadow-soft-xl rounded-2xl p-3 flex flex-col items-center justify-center text-center hover:shadow-soft-2xl hover:-translate-y-0.5 transition-all duration-200 border border-transparent hover:border-blue-100">
            <div class="w-9 h-9 rounded-xl bg-gradient-to-tl from-blue-500 to-cyan-400 flex items-center justify-center shadow-soft-md mb-2 group-hover:scale-110 transition-transform">
                <i class="fa fa-id-card  text-xs"></i>
            </div>
            <span class="text-xs font-semibold text-slate-600 group-hover:text-blue-500 transition-colors leading-tight">Profile</span>
            <span class="text-xs text-slate-400 leading-tight mt-0.5">Identity</span>
        </a>

        {{-- Employment --}}
        <a href="#"
           class="group bg-white shadow-soft-xl rounded-2xl p-3 flex flex-col items-center justify-center text-center hover:shadow-soft-2xl hover:-translate-y-0.5 transition-all duration-200 border border-transparent hover:border-green-100">
            <div class="w-9 h-9 rounded-xl bg-gradient-to-tl from-green-500 to-emerald-400 flex items-center justify-center shadow-soft-md mb-2 group-hover:scale-110 transition-transform">
                <i class="fa fa-briefcase  text-xs"></i>
            </div>
            <span class="text-xs font-semibold text-slate-600 group-hover:text-green-500 transition-colors leading-tight">Employment</span>
            <span class="text-xs text-slate-400 leading-tight mt-0.5">Staff & Status</span>
        </a>

        {{-- Qualification --}}
        <a href="#"
           class="group bg-white shadow-soft-xl rounded-2xl p-3 flex flex-col items-center justify-center text-center hover:shadow-soft-2xl hover:-translate-y-0.5 transition-all duration-200 border border-transparent hover:border-purple-100">
            <div class="w-9 h-9 rounded-xl bg-gradient-to-tl from-purple-600 to-pink-500 flex items-center justify-center shadow-soft-md mb-2 group-hover:scale-110 transition-transform">
                <i class="fa fa-graduation-cap  text-xs"></i>
            </div>
            <span class="text-xs font-semibold text-slate-600 group-hover:text-purple-500 transition-colors leading-tight">Qualification</span>
            <span class="text-xs text-slate-400 leading-tight mt-0.5">Academics</span>
        </a>

        {{-- Teaching --}}
        <a href="#"
           class="group bg-white shadow-soft-xl rounded-2xl p-3 flex flex-col items-center justify-center text-center hover:shadow-soft-2xl hover:-translate-y-0.5 transition-all duration-200 border border-transparent hover:border-orange-100">
            <div class="w-9 h-9 rounded-xl bg-gradient-to-tl from-orange-500 to-yellow-400 flex items-center justify-center shadow-soft-md mb-2 group-hover:scale-110 transition-transform">
                <i class="fa fa-book-open  text-xs"></i>
            </div>
            <span class="text-xs font-semibold text-slate-600 group-hover:text-orange-500 transition-colors leading-tight">Teaching</span>
            <span class="text-xs text-slate-400 leading-tight mt-0.5">Subjects</span>
        </a>

        {{-- Performance --}}
        <a href="#"
           class="group bg-white shadow-soft-xl rounded-2xl p-3 flex flex-col items-center justify-center text-center hover:shadow-soft-2xl hover:-translate-y-0.5 transition-all duration-200 border border-transparent hover:border-red-100">
            <div class="w-9 h-9 rounded-xl bg-gradient-to-tl from-red-500 to-rose-400 flex items-center justify-center shadow-soft-md mb-2 group-hover:scale-110 transition-transform">
                <i class="fa fa-chart-line text-white text-xs"></i>
            </div>
            <span class="text-xs font-semibold text-slate-600 group-hover:text-red-500 transition-colors leading-tight">Performance</span>
            <span class="text-xs text-slate-400 leading-tight mt-0.5">Ranks & Evals</span>
        </a>

        {{-- Access Control --}}
        <a href="#"
           class="group bg-white shadow-soft-xl rounded-2xl p-3 flex flex-col items-center justify-center text-center hover:shadow-soft-2xl hover:-translate-y-0.5 transition-all duration-200 border border-transparent hover:border-slate-200">
            <div class="w-9 h-9 rounded-xl bg-gradient-to-tl from-slate-600 to-slate-400 flex items-center justify-center shadow-soft-md mb-2 group-hover:scale-110 transition-transform">
                <i class="fa fa-shield-alt text-white text-xs"></i>
            </div>
            <span class="text-xs font-semibold text-slate-600 group-hover:text-slate-500 transition-colors leading-tight">Access</span>
            <span class="text-xs text-slate-400 leading-tight mt-0.5">Permissions</span>
        </a>

    </div>
</div>

    {{-- ═══════════════════════════════════════════
         TEACHERS TABLE
    ═══════════════════════════════════════════ --}}
    <div class="bg-white rounded-2xl shadow-soft-xl overflow-hidden">

        {{-- Table Header --}}
        <div class="flex flex-wrap items-center justify-between px-6 py-4 border-b border-gray-100 gap-3">
            <div>
                <h6 class="font-bold text-slate-700">All Teachers</h6>
                <p class="text-xs text-slate-400 mt-0.5">Showing 1–10 of 24 teachers</p>
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
            <span class="text-xs text-slate-300 italic">Not assigned</span>
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
                <a href="#"
                   class="w-7 h-7 rounded-lg bg-amber-50 text-amber-500 flex items-center justify-center hover:bg-amber-100 transition-colors"
                   title="Edit">
                    <i class="fa fa-pen text-xs"></i>
                </a>
                <form method="POST"
                      action="#"
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
            <p class="text-xs text-slate-400">Showing <span class="font-semibold text-slate-600">1–3</span> of <span class="font-semibold text-slate-600">24</span> teachers</p>
            <div class="flex gap-1">
                <button class="w-8 h-8 rounded-lg border border-gray-200 text-slate-400 text-sm hover:bg-gray-50 transition-colors flex items-center justify-center">
                    <i class="fa fa-chevron-left text-xs"></i>
                </button>
                <button class="w-8 h-8 rounded-lg bg-gradient-to-tl from-gray-900 to-slate-700 text-white text-sm flex items-center justify-center">1</button>
                <button class="w-8 h-8 rounded-lg border border-gray-200 text-slate-500 text-sm hover:bg-gray-50 transition-colors flex items-center justify-center">2</button>
                <button class="w-8 h-8 rounded-lg border border-gray-200 text-slate-500 text-sm hover:bg-gray-50 transition-colors flex items-center justify-center">3</button>
                <button class="w-8 h-8 rounded-lg border border-gray-200 text-slate-400 text-sm hover:bg-gray-50 transition-colors flex items-center justify-center">
                    <i class="fa fa-chevron-right text-xs"></i>
                </button>
            </div>
        </div>

    </div>

</div>

@endsection