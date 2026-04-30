@extends('layouts.admin')

@section('content')

@php $subdomain = request()->route('subdomain'); @endphp

<div class="w-full px-6 py-6 mx-auto">

    {{-- PAGE HEADER --}}
    <div class="flex flex-wrap items-center justify-between mb-6 -mx-3">
        <div class="px-3">
            <h3 class="text-2xl font-bold text-slate-700 mb-1">My Students</h3>
            <p class="text-sm text-slate-400">
                <i class="fa fa-home mr-1"></i> Dashboard
                <span class="mx-1 text-slate-300">/</span>
                <a href="{{ route('tenant.teacher.dashboard', $subdomain) }}" class="hover:text-slate-600">Teacher</a>
                <span class="mx-1 text-slate-300">/</span>
                <span class="text-slate-600">My Students</span>
            </p>
        </div>
        <div class="px-3 mt-3 md:mt-0">
            <a href="{{ route('tenant.teacher.dashboard', $subdomain) }}"
               class="px-4 py-2 text-sm border border-gray-300 rounded-lg text-slate-600 hover:bg-gray-50 transition-all">
                <i class="fa fa-arrow-left mr-1"></i> Back
            </a>
        </div>
    </div>

    {{-- STAT STRIP --}}
    <div class="flex flex-wrap -mx-3 mb-6">
        <div class="w-full px-3 lg:w-1/2">
            <div class="grid grid-cols-3 gap-4">

                {{-- Total --}}
                <div class="relative bg-white shadow-soft-xl rounded-2xl px-4 py-3 overflow-hidden flex items-center gap-3">
                    <div class="absolute top-0 right-0 w-16 h-16 rounded-full bg-gradient-to-tl from-blue-500 to-cyan-400 opacity-10 -mr-3 -mt-3"></div>
                    <div class="w-9 h-9 rounded-xl bg-gradient-to-tl from-blue-500 to-cyan-400 flex items-center justify-center shadow-soft-md flex-shrink-0">
                        <i class="fa fa-user-graduate text-black text-xs"></i>
                    </div>
                    <div>
                        <h5 class="text-lg font-bold text-slate-700 leading-none mb-0.5">{{ $students->count() }}</h5>
                        <p class="text-xs text-slate-400 leading-none">Total</p>
                    </div>
                </div>

                {{-- Male --}}
                <div class="relative bg-white shadow-soft-xl rounded-2xl px-4 py-3 overflow-hidden flex items-center gap-3">
                    <div class="absolute top-0 right-0 w-16 h-16 rounded-full bg-gradient-to-tl from-purple-600 to-pink-500 opacity-10 -mr-3 -mt-3"></div>
                    <div class="w-9 h-9 rounded-xl bg-gradient-to-tl from-purple-600 to-pink-500 flex items-center justify-center shadow-soft-md flex-shrink-0">
                        <i class="fa fa-mars text-black text-xs"></i>
                    </div>
                    <div>
                        <h5 class="text-lg font-bold text-slate-700 leading-none mb-0.5">{{ $students->where('gender', 'male')->count() }}</h5>
                        <p class="text-xs text-slate-400 leading-none">Male</p>
                    </div>
                </div>

                {{-- Female --}}
                <div class="relative bg-white shadow-soft-xl rounded-2xl px-4 py-3 overflow-hidden flex items-center gap-3">
                    <div class="absolute top-0 right-0 w-16 h-16 rounded-full bg-gradient-to-tl from-pink-500 to-rose-400 opacity-10 -mr-3 -mt-3"></div>
                    <div class="w-9 h-9 rounded-xl bg-gradient-to-tl from-pink-500 to-rose-400 flex items-center justify-center shadow-soft-md flex-shrink-0">
                        <i class="fa fa-venus text-black text-xs"></i>
                    </div>
                    <div>
                        <h5 class="text-lg font-bold text-slate-700 leading-none mb-0.5">{{ $students->where('gender', 'female')->count() }}</h5>
                        <p class="text-xs text-slate-400 leading-none">Female</p>
                    </div>
                </div>

            </div>
        </div>

        <div class="w-full px-3 mt-4 lg:mt-0 lg:w-1/2">
            <div class="grid grid-cols-3 gap-4">

                {{-- JSS --}}
                <div class="relative bg-white shadow-soft-xl rounded-2xl px-4 py-3 overflow-hidden flex items-center gap-3">
                    <div class="absolute top-0 right-0 w-16 h-16 rounded-full bg-gradient-to-tl from-green-500 to-emerald-400 opacity-10 -mr-3 -mt-3"></div>
                    <div class="w-9 h-9 rounded-xl bg-gradient-to-tl from-green-500 to-emerald-400 flex items-center justify-center shadow-soft-md flex-shrink-0">
                        <i class="fa fa-school text-black text-xs"></i>
                    </div>
                    <div>
                        <h5 class="text-lg font-bold text-slate-700 leading-none mb-0.5">
                            {{ $students->filter(fn($s) => str_starts_with($s->class ?? '', 'JSS'))->count() }}
                        </h5>
                        <p class="text-xs text-slate-400 leading-none">JSS</p>
                    </div>
                </div>

                {{-- SS --}}
                <div class="relative bg-white shadow-soft-xl rounded-2xl px-4 py-3 overflow-hidden flex items-center gap-3">
                    <div class="absolute top-0 right-0 w-16 h-16 rounded-full bg-gradient-to-tl from-orange-500 to-yellow-400 opacity-10 -mr-3 -mt-3"></div>
                    <div class="w-9 h-9 rounded-xl bg-gradient-to-tl from-orange-500 to-yellow-400 flex items-center justify-center shadow-soft-md flex-shrink-0">
                        <i class="fa fa-book text-black text-xs"></i>
                    </div>
                    <div>
                        <h5 class="text-lg font-bold text-slate-700 leading-none mb-0.5">
                            {{ $students->filter(fn($s) => str_starts_with($s->class ?? '', 'SS'))->count() }}
                        </h5>
                        <p class="text-xs text-slate-400 leading-none">SS</p>
                    </div>
                </div>

                {{-- Classes --}}
                <div class="relative bg-white shadow-soft-xl rounded-2xl px-4 py-3 overflow-hidden flex items-center gap-3">
                    <div class="absolute top-0 right-0 w-16 h-16 rounded-full bg-gradient-to-tl from-slate-600 to-slate-400 opacity-10 -mr-3 -mt-3"></div>
                    <div class="w-9 h-9 rounded-xl bg-gradient-to-tl from-slate-600 to-slate-400 flex items-center justify-center shadow-soft-md flex-shrink-0">
                        <i class="fa fa-chalkboard text-white text-xs"></i>
                    </div>
                    <div>
                        <h5 class="text-lg font-bold text-slate-700 leading-none mb-0.5">
                            {{ $students->pluck('class')->filter()->unique()->count() }}
                        </h5>
                        <p class="text-xs text-slate-400 leading-none">Classes</p>
                    </div>
                </div>

            </div>
        </div>
    </div>

    {{-- STUDENTS TABLE --}}
    <div class="bg-white rounded-2xl shadow-soft-xl overflow-hidden">

        {{-- Table Header --}}
        <div class="flex flex-wrap items-center justify-between px-6 py-4 border-b border-gray-100 gap-3">
            <div>
                <h6 class="font-bold text-slate-700">My Students</h6>
                <p class="text-xs text-slate-400 mt-0.5">
                    Total: <span class="font-semibold text-slate-600">{{ $students->count() }}</span>
                    {{ Str::plural('student', $students->count()) }}
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
                    <option value="JSS1">JSS1</option>
                    <option value="JSS2">JSS2</option>
                    <option value="JSS3">JSS3</option>
                    <option value="SS1">SS1</option>
                    <option value="SS2">SS2</option>
                    <option value="SS3">SS3</option>
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
                        <th class="px-6 py-3 text-center text-xxs font-bold uppercase tracking-wider text-slate-400 opacity-70">Actions</th>
                    </tr>
                </thead>
                <tbody>

                    @forelse($students as $index => $student)
                    <tr class="border-t border-gray-100 hover:bg-gray-50 transition-colors">

                        {{-- # --}}
                        <td class="px-6 py-3 align-middle">
                            <span class="text-xs text-slate-400">{{ $index + 1 }}</span>
                        </td>

                        {{-- Student --}}
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

                        {{-- Student ID --}}
                        <td class="px-6 py-3 align-middle">
                            <span class="text-xs font-mono font-semibold bg-slate-100 text-slate-600 px-2 py-1 rounded-lg">
                                {{ $student->student_id }}
                            </span>
                        </td>

                        {{-- Class --}}
                        <td class="px-6 py-3 align-middle">
                            @if($student->class)
                                @php
                                    $classColors = [
                                        'JSS1' => 'bg-blue-50 text-blue-600',
                                        'JSS2' => 'bg-cyan-50 text-cyan-600',
                                        'JSS3' => 'bg-teal-50 text-teal-600',
                                        'SS1'  => 'bg-purple-50 text-purple-600',
                                        'SS2'  => 'bg-orange-50 text-orange-600',
                                        'SS3'  => 'bg-red-50 text-red-600',
                                    ];
                                    $classColor = $classColors[$student->class] ?? 'bg-gray-100 text-gray-600';
                                @endphp
                                <span class="text-xs font-semibold {{ $classColor }} px-2 py-1 rounded-lg">
                                    {{ $student->class }}
                                </span>
                            @else
                                <span class="text-xs text-slate-300">—</span>
                            @endif
                        </td>

                        {{-- Gender --}}
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

                        {{-- Actions --}}
                        <td class="px-6 py-3 align-middle text-center">
                            <div class="flex items-center justify-center gap-2">
                                <a href="#"
                                   class="w-7 h-7 rounded-lg bg-blue-50 text-blue-500 flex items-center justify-center hover:bg-blue-100 transition-colors"
                                   title="View">
                                    <i class="fa fa-eye text-xs"></i>
                                </a>
                                <a href="#"
                                   class="w-7 h-7 rounded-lg bg-green-50 text-green-500 flex items-center justify-center hover:bg-green-100 transition-colors"
                                   title="Attendance">
                                    <i class="fa fa-clipboard-check text-xs"></i>
                                </a>
                                <a href="#"
                                   class="w-7 h-7 rounded-lg bg-purple-50 text-purple-500 flex items-center justify-center hover:bg-purple-100 transition-colors"
                                   title="Results">
                                    <i class="fa fa-star text-xs"></i>
                                </a>
                            </div>
                        </td>

                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center">
                            <div class="flex flex-col items-center">
                                <div class="w-16 h-16 rounded-2xl bg-gray-100 flex items-center justify-center mb-4">
                                    <i class="fa fa-user-graduate text-gray-400 text-2xl"></i>
                                </div>
                                <p class="text-slate-500 font-semibold">No students assigned yet</p>
                                <p class="text-slate-400 text-sm mt-1">Students assigned to you will appear here</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse

                </tbody>
            </table>
        </div>

        {{-- Footer --}}
        <div class="flex items-center justify-between px-6 py-4 border-t border-gray-100">
            <p class="text-xs text-slate-400">
                Total: <span class="font-semibold text-slate-600">{{ $students->count() }}</span>
                {{ Str::plural('student', $students->count()) }}
            </p>
        </div>

    </div>

</div>

{{-- Live search + filter --}}
<script>
function filterTable() {
    const search = document.getElementById('searchInput').value.toLowerCase();
    const classFilter = document.getElementById('classFilter').value.toLowerCase();
    const rows = document.querySelectorAll('#studentsTable tbody tr');
    rows.forEach(row => {
        const text = row.innerText.toLowerCase();
        const matchSearch = text.includes(search);
        const matchClass = classFilter === '' || text.includes(classFilter);
        row.style.display = (matchSearch && matchClass) ? '' : 'none';
    });
}
</script>

@endsection