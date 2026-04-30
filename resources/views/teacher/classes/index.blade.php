@extends('layouts.admin')

@section('content')

@php $subdomain = request()->route('subdomain'); @endphp

<div class="w-full px-6 py-6 mx-auto">

    {{-- PAGE HEADER --}}
    <div class="flex flex-wrap items-center justify-between mb-6 -mx-3">
        <div class="px-3">
            <h3 class="text-2xl font-bold text-slate-700 mb-1">My Classes & Students</h3>
            <p class="text-sm text-slate-400">
                <i class="fa fa-home mr-1"></i> Dashboard
                <span class="mx-1 text-slate-300">/</span>
                <span class="text-slate-600">Classes Overview</span>
            </p>
        </div>
    </div>

    @if(session('error'))
        <div class="p-4 mb-6 text-sm text-red-700 bg-red-50 border border-red-200 rounded-2xl flex items-center gap-3">
            <div class="w-8 h-8 rounded-lg bg-gradient-to-tl from-red-500 to-rose-400 flex items-center justify-center flex-shrink-0">
                <i class="fa fa-exclamation-circle text-primary text-xs"></i>
            </div>
            <p class="font-semibold">{{ session('error') }}</p>
        </div>
    @endif

    @if($students->isEmpty())
        <div class="bg-white rounded-2xl shadow-soft-xl p-12 text-center">
            <div class="w-20 h-20 rounded-2xl bg-gray-100 flex items-center justify-center mb-4 mx-auto">
                <i class="fa fa-user-graduate text-gray-400 text-3xl"></i>
            </div>
            <p class="text-slate-500 font-semibold text-lg">No students assigned yet</p>
            <p class="text-slate-400 text-sm mt-1">You don't have any students assigned to you at the moment.</p>
        </div>
    @else

        {{-- STAT CARDS ROW 1 — 4 CARDS --}}
        <div class="flex flex-wrap -mx-3 mb-6">
            
            <!-- card1 - Total Classes -->
            <div class="w-full max-w-full px-3 mb-6 sm:w-1/2 sm:flex-none xl:mb-0 xl:w-1/4">
                <div class="relative flex flex-col min-w-0 break-words bg-white shadow-soft-xl rounded-2xl bg-clip-border">
                    <div class="flex-auto p-4">
                        <div class="flex flex-row -mx-3">
                            <div class="flex-none w-2/3 max-w-full px-3">
                                <div>
                                    <p class="mb-0 font-sans text-sm font-semibold leading-normal">My Classes</p>
                                    <h5 class="mb-0 font-bold">
                                        {{ $totalClasses }}
                                        <span class="text-sm leading-normal font-weight-bolder text-purple-500">classes</span>
                                    </h5>
                                </div>
                            </div>
                            <div class="px-3 text-right basis-1/3">
                                <div class="inline-block w-12 h-12 text-center rounded-lg bg-gradient-to-tl from-purple-600 to-pink-500">
                                    <i class="fa fa-chalkboard text-lg relative top-3.5 text-primary"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- card2 - Total Students -->
            <div class="w-full max-w-full px-3 mb-6 sm:w-1/2 sm:flex-none xl:mb-0 xl:w-1/4">
                <div class="relative flex flex-col min-w-0 break-words bg-white shadow-soft-xl rounded-2xl bg-clip-border">
                    <div class="flex-auto p-4">
                        <div class="flex flex-row -mx-3">
                            <div class="flex-none w-2/3 max-w-full px-3">
                                <div>
                                    <p class="mb-0 font-sans text-sm font-semibold leading-normal">Total Students</p>
                                    <h5 class="mb-0 font-bold">
                                        {{ $totalStudents }}
                                        <span class="text-sm leading-normal font-weight-bolder text-blue-500">assigned</span>
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

            <!-- card3 - Male Students -->
            <div class="w-full max-w-full px-3 mb-6 sm:w-1/2 sm:flex-none xl:mb-0 xl:w-1/4">
                <div class="relative flex flex-col min-w-0 break-words bg-white shadow-soft-xl rounded-2xl bg-clip-border">
                    <div class="flex-auto p-4">
                        <div class="flex flex-row -mx-3">
                            <div class="flex-none w-2/3 max-w-full px-3">
                                <div>
                                    <p class="mb-0 font-sans text-sm font-semibold leading-normal">Male Students</p>
                                    <h5 class="mb-0 font-bold">
                                        {{ $maleStudents }}
                                        <span class="text-sm leading-normal font-weight-bolder text-blue-600">{{ $malePercentage }}%</span>
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

            <!-- card4 - Female Students -->
            <div class="w-full max-w-full px-3 sm:w-1/2 sm:flex-none xl:w-1/4">
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

        </div>

        {{-- STUDENTS TABLE --}}
        <div class="bg-white rounded-2xl shadow-soft-xl overflow-hidden">

            {{-- Table Header --}}
            <div class="flex flex-wrap items-center justify-between px-6 py-4 border-b border-gray-100 gap-3">
                <div>
                    <h6 class="font-bold text-slate-700">My Students</h6>
                    <p class="text-xs text-slate-400 mt-0.5">
                     Total: <span id="visibleStudentCount" class="font-semibold text-slate-600">{{ $students->count() }}</span>
                      <span id="visibleStudentLabel">{{ Str::plural('student', $students->count()) }}</span>
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
                        @foreach($allClasses as $class)
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
                            <th class="px-6 py-3 text-left text-xxs font-bold uppercase tracking-wider text-slate-400 opacity-70">Email</th>
                            <th class="px-6 py-3 text-left text-xxs font-bold uppercase tracking-wider text-slate-400 opacity-70">Phone</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($students as $index => $student)
                        <tr class="border-t border-gray-100 hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-3 align-middle">
                                <span class="text-xs text-slate-400">{{ $index + 1 }}</span>
                            </td>
                            <td class="px-6 py-3 align-middle">
                                <div class="flex items-center gap-3">
                                    <div class="w-9 h-9 rounded-xl flex items-center justify-center text-primary text-sm font-bold shadow-soft-md flex-shrink-0
                                        {{ $student->gender === 'female'
                                            ? 'bg-gradient-to-tl from-pink-500 to-rose-400'
                                            : 'bg-gradient-to-tl from-blue-500 to-cyan-400' }}">
                                        {{ strtoupper(substr($student->name, 0, 2)) }}
                                    </div>
                                    <div>
                                        <p class="text-sm font-semibold text-slate-700 mb-0">{{ $student->name }}</p>
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
                                <span class="text-sm text-slate-600">{{ $student->email ?? '—' }}</span>
                            </td>
                            <td class="px-6 py-3 align-middle">
                                <span class="text-sm text-slate-600">{{ $student->phone ?? '—' }}</span>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center">
                                    <div class="w-16 h-16 rounded-2xl bg-gray-100 flex items-center justify-center mb-4">
                                        <i class="fa fa-user-graduate text-gray-400 text-2xl"></i>
                                    </div>
                                    <p class="text-slate-500 font-semibold">No students found</p>
                                    <p class="text-slate-400 text-sm mt-1">No students are assigned to you yet.</p>
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
                    Total: <span class="font-semibold text-slate-600">{{ $students->count() }}</span>
                    {{ Str::plural('student', $students->count()) }}
                </p>
                
            </div>

        </div>

    @endif

</div>

<script>
function filterTable() {
    const searchTerm = document.getElementById('searchInput').value.toLowerCase();
    const selectedClass = document.getElementById('classFilter').value;
    const rows = document.querySelectorAll('#studentsTable tbody tr');
    let visibleCount = 0;

    rows.forEach(row => {
        // Get student name (2nd column)
        const nameCell = row.querySelector('td:nth-child(2)');
        const studentName = nameCell ? nameCell.innerText.toLowerCase() : '';
        
        // Get student ID (3rd column)
        const idCell = row.querySelector('td:nth-child(3)');
        const studentId = idCell ? idCell.innerText.toLowerCase() : '';
        
        // Get class (4th column)
        const classCell = row.querySelector('td:nth-child(4)');
        const className = classCell ? classCell.innerText.trim() : '';
        
        // Get gender (5th column)
        const genderCell = row.querySelector('td:nth-child(5)');
        const gender = genderCell ? genderCell.innerText.toLowerCase() : '';
        
        // Check search match (name, ID, or gender)
        const matchesSearch = searchTerm === '' || 
                              studentName.includes(searchTerm) || 
                              studentId.includes(searchTerm) ||
                              gender.includes(searchTerm);
        
        // Check class match
        const matchesClass = selectedClass === '' || className === selectedClass;
        
        // Show/hide row
        if (matchesSearch && matchesClass) {
            row.style.display = '';
            visibleCount++;
        } else {
            row.style.display = 'none';
        }
    });
    
    // Update the visible count display
    const countSpan = document.getElementById('visibleStudentCount');
    const labelSpan = document.getElementById('visibleStudentLabel');
    if (countSpan) {
        countSpan.textContent = visibleCount;
    }
    if (labelSpan) {
        labelSpan.textContent = visibleCount === 1 ? 'student' : 'students';
    }
}</script>

@endsection