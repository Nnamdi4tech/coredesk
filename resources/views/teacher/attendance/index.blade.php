@extends('layouts.admin')

@section('content')

@php $subdomain = request()->route('subdomain'); @endphp

<div class="w-full px-6 py-6 mx-auto">

    {{-- PAGE HEADER --}}
    <div class="flex flex-wrap items-center justify-between mb-6 -mx-3">
        <div class="px-3">
            <h3 class="text-2xl font-bold text-slate-700 mb-1">Student-Subjects Attendance</h3>
            <p class="text-sm text-slate-400">
                <i class="fa fa-home mr-1"></i> Dashboard
                <span class="mx-1 text-slate-300">/</span>
                <span class="text-slate-600">Attendance Management</span>
            </p>
        </div>
        <div class="px-3 mt-3 md:mt-0">
            <a href="{{ route('teacher.attendance.view', $subdomain) }}" 
               class="px-4 py-2 text-sm font-semibold text-black rounded-lg bg-gradient-to-tl from-blue-600 to-cyan-500 shadow-soft-md hover:shadow-soft-xl transition-all">
                <i class="fa fa-history mr-1"></i> View Records
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="p-4 mb-6 text-sm text-green-700 bg-green-50 border border-green-200 rounded-2xl flex items-center gap-3">
            <div class="w-8 h-8 rounded-lg bg-gradient-to-tl from-green-500 to-emerald-400 flex items-center justify-center flex-shrink-0">
                <i class="fa fa-check text-black text-xs"></i>
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
                <i class="fa fa-exclamation-circle text-black text-xs"></i>
            </div>
            <p class="font-semibold">{{ session('error') }}</p>
            <button onclick="this.parentElement.remove()" class="ml-auto text-red-400 hover:text-red-600">
                <i class="fa fa-times text-xs"></i>
            </button>
        </div>
    @endif

    {{-- FILTER SECTION --}}
    <div class="bg-white shadow-soft-xl rounded-2xl p-4 mb-6">
        <div class="flex items-center gap-2 mb-3 pb-2 border-b border-gray-100">
            <div class="w-6 h-6 rounded-lg bg-gradient-to-tl from-slate-600 to-slate-400 flex items-center justify-center">
                <i class="fa fa-filter text-black text-xs"></i>
            </div>
            <h6 class="font-bold text-slate-700 text-sm">Filter Attendance</h6>
        </div>
        
        <form method="GET" action="{{ route('teacher.attendance.index', $subdomain) }}" class="flex flex-wrap items-end gap-3">
            <div class="flex-1 min-w-[180px]">
                <label class="block text-xs font-semibold text-slate-500 mb-1">Classes</label>
                <select name="class_id" class="text-sm w-full rounded-lg border border-gray-300 bg-white py-2 px-3 focus:outline-none focus:border-fuchsia-300">
                    <option value="">Select Class</option>
                    @foreach($classes as $class)
                        <option value="{{ $class->id }}" {{ $selectedClass == $class->id ? 'selected' : '' }}>
                            {{ $class->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            
            <div class="flex-1 min-w-[180px]">
                <label class="block text-xs font-semibold text-slate-500 mb-1">Subjects / Courses</label>
                <select name="subject_id" class="text-sm w-full rounded-lg border border-gray-300 bg-white py-2 px-3 focus:outline-none focus:border-fuchsia-300">
                    <option value="">Select Subjects</option>
                    @foreach($subjects as $subject)
                        <option value="{{ $subject->id }}" {{ $selectedSubject == $subject->id ? 'selected' : '' }}>
                            {{ $subject->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            
            <div class="flex-1 min-w-[150px]">
                <label class="block text-xs font-semibold text-slate-500 mb-1">Term / Semester</label>
                <select name="term" class="text-sm w-full rounded-lg border border-gray-300 bg-white py-2 px-3 focus:outline-none focus:border-fuchsia-300">
                    @foreach($availableTerms as $term)
                        <option value="{{ $term }}" {{ $selectedTerm == $term ? 'selected' : '' }}>
                            {{ $term }}
                        </option>
                    @endforeach
                </select>
            </div>
            
            <div class="flex-1 min-w-[150px]">
                <label class="block text-xs font-semibold text-slate-500 mb-1">Session</label>
                <select name="session" class="text-sm w-full rounded-lg border border-gray-300 bg-white py-2 px-3 focus:outline-none focus:border-fuchsia-300">
                    @foreach($availableSessions as $session)
                        <option value="{{ $session }}" {{ $selectedSession == $session ? 'selected' : '' }}>
                            {{ $session }}
                        </option>
                    @endforeach
                </select>
            </div>
            
            <div>
                <button type="submit" class="px-5 py-2 text-sm font-semibold text-black rounded-lg bg-gradient-to-tl from-blue-600 to-cyan-500 shadow-soft-md hover:shadow-soft-xl transition-all">
                    <i class="fa fa-search mr-1"></i> Apply Filters
                </button>
            </div>
            
            <div>
                <a href="{{ route('teacher.attendance.index', $subdomain) }}" class="px-5 py-2 text-sm font-semibold text-slate-600 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition-all">
                    <i class="fa fa-times mr-1"></i> Clear
                </a>
            </div>
        </form>
    </div>

    {{-- INFO CARD --}}
    <div class="bg-gradient-to-r from-blue-50 to-cyan-50 rounded-2xl p-4 mb-6 border border-blue-100">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-lg bg-gradient-to-tl from-blue-500 to-cyan-400 flex items-center justify-center">
                <i class="fa fa-info-circle text-black text-sm"></i>
            </div>
            <div>
                <p class="text-sm font-semibold text-blue-800">Attendance Information</p>
                <p class="text-xs text-blue-600">Term: <strong>{{ $selectedTerm }}</strong> | Session: <strong>{{ $selectedSession }}</strong></p>
                <p class="text-xs text-blue-600 mt-1">⚠️ Once submitted, attendance records cannot be edited. Please ensure all scores are correct before submitting.</p>
            </div>
        </div>
    </div>

    @if($students->isEmpty())
        <div class="bg-white rounded-2xl shadow-soft-xl p-12 text-center">
            <div class="w-20 h-20 rounded-2xl bg-gray-100 flex items-center justify-center mb-4 mx-auto">
                <i class="fa fa-users text-gray-400 text-3xl"></i>
            </div>
            <p class="text-slate-500 font-semibold text-lg">No students found</p>
            <p class="text-slate-400 text-sm mt-1">No students match your filter criteria.</p>
        </div>
    @elseif(!$selectedSubject)
        <div class="bg-white rounded-2xl shadow-soft-xl p-12 text-center">
            <div class="w-20 h-20 rounded-2xl bg-gray-100 flex items-center justify-center mb-4 mx-auto">
                <i class="fa fa-book text-gray-400 text-3xl"></i>
            </div>
            <p class="text-slate-500 font-semibold text-lg">Please select a subject</p>
            <p class="text-slate-400 text-sm mt-1">Use the filters above to select a subject and record attendance.</p>
        </div>
    @else
        <form method="POST" action="{{ route('teacher.attendance.store', $subdomain) }}" id="attendanceForm">
            @csrf
            <input type="hidden" name="term" value="{{ $selectedTerm }}">
            <input type="hidden" name="session" value="{{ $selectedSession }}">
            
            <div class="bg-white rounded-2xl shadow-soft-xl overflow-hidden mb-6">
                <div class="px-6 py-4 border-b border-gray-100 bg-gradient-to-r from-purple-50 to-pink-50">
                    <div class="flex items-center gap-2">
                        <div class="w-8 h-8 rounded-lg bg-gradient-to-tl from-purple-600 to-pink-500 flex items-center justify-center">
                            <i class="fa fa-book text-black text-xs"></i>
                        </div>
                        <h6 class="font-bold text-slate-700">{{ $subjects->firstWhere('id', $selectedSubject)->name ?? 'Selected Subject' }}</h6>
                        <span class="text-xs text-slate-400 ml-2">(Course Code: {{ $subjects->firstWhere('id', $selectedSubject)->course_code ?? 'N/A' }})</span>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full mb-0 align-top border-gray-200 text-slate-500">
                        <thead class="align-bottom bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xxs font-bold uppercase">#</th>
                                <th class="px-6 py-3 text-left text-xxs font-bold uppercase">Student</th>
                                <th class="px-6 py-3 text-left text-xxs font-bold uppercase">Student ID</th>
                                <th class="px-6 py-3 text-left text-xxs font-bold uppercase">Class</th>
                                <th class="px-6 py-3 text-center text-xxs font-bold uppercase">Score (1-10)</th>
                                <th class="px-6 py-3 text-left text-xxs font-bold uppercase">Rating</th>
                                <th class="px-6 py-3 text-left text-xxs font-bold uppercase">Remarks</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($students as $index => $student)
                            @php
    // Find the attendance record for this student and subject
    $existing = $existingAttendance->first(function($item) use ($student, $selectedSubject) {
        return $item->student_id == $student->id && $item->subject_id == $selectedSubject;
    });
    $isRecorded = !is_null($existing);
    $currentScore = $isRecorded ? $existing->score : '';
    $currentRating = $isRecorded ? $existing->rating : '';
    $ratingColor = $currentRating ? \App\Models\Attendance::getRatingColor($currentRating) : '';
@endphp
                            <tr class="border-t border-gray-100 hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-3">{{ $index + 1 }}</td>
                                <td class="px-6 py-3">
                                    <div class="flex items-center gap-3">
                                        <div class="w-9 h-9 rounded-xl flex items-center justify-center text-black text-sm font-bold shadow-soft-md
                                            {{ $student->gender === 'female' ? 'bg-gradient-to-tl from-pink-500 to-rose-400' : 'bg-gradient-to-tl from-blue-500 to-cyan-400' }}">
                                            {{ strtoupper(substr($student->name, 0, 2)) }}
                                        </div>
                                        <div>
                                            <p class="text-sm font-semibold text-slate-700 mb-0">{{ $student->name }}</p>
                                            <p class="text-xs text-slate-400">{{ $student->email ?? '—' }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-3">
                                    <span class="text-xs font-mono font-semibold bg-slate-100 text-slate-600 px-2 py-1 rounded-lg">
                                        {{ $student->student_id }}
                                    </span>
                                </td>
                                <td class="px-6 py-3">
                                    <span class="text-xs font-semibold bg-purple-50 text-purple-600 px-2 py-1 rounded-lg">
                                        {{ $student->schoolClass->name ?? 'N/A' }}
                                    </span>
                                </td>
                                <td class="px-6 py-3 text-center">
                                    <input type="hidden" name="attendance[{{ $index }}][student_id]" value="{{ $student->id }}">
                                    <input type="hidden" name="attendance[{{ $index }}][subject_id]" value="{{ $selectedSubject }}">
                                    <input type="hidden" name="attendance[{{ $index }}][class_id]" value="{{ $student->class_id }}">
                                    
                                    @if($isRecorded)
                                        <span class="inline-block px-3 py-2 text-sm font-semibold text-green-600 bg-green-50 rounded-lg">
                                            {{ $currentScore }} / 10
                                        </span>
                                        <input type="hidden" name="attendance[{{ $index }}][score]" value="{{ $currentScore }}">
                                    @else
                                        <input type="number" 
                                               name="attendance[{{ $index }}][score]"
                                               data-index="{{ $index }}"
                                               data-student="{{ $student->name }}"
                                               min="1" max="10"
                                               step="1"
                                               onchange="updateRating(this, {{ $index }})"
                                               class="attendance-score w-20 text-center text-sm rounded-lg border border-gray-300 bg-white py-2 px-2 text-gray-700 focus:outline-none focus:border-fuchsia-300 transition-all">
                                    @endif
                                </td>
                                <td class="px-6 py-3">
                                    <span id="rating_{{ $index }}" class="text-xs font-semibold px-3 py-1 rounded-full {{ $ratingColor ?: 'bg-gray-50 text-gray-600' }}">
                                        {{ $currentRating ?: 'Not set' }}
                                    </span>
                                </td>
                                <td class="px-6 py-3">
                                    @if($isRecorded)
                                        <span class="text-xs text-slate-400">{{ $existing->remarks ?? '—' }}</span>
                                    @else
                                        <input type="text" 
                                               name="attendance[{{ $index }}][remarks]"
                                               placeholder="Optional remarks..."
                                               class="w-full text-sm rounded-lg border border-gray-300 bg-white py-2 px-3 text-gray-700 focus:outline-none focus:border-fuchsia-300 transition-all">
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="flex justify-end gap-3 mt-4">
                <button type="button" onclick="confirmSubmit()" class="px-8 py-2.5 text-sm font-semibold text-black rounded-lg bg-gradient-to-tl from-gray-900 to-slate-700 shadow-soft-md hover:shadow-soft-xl hover:scale-105 transition-all">
                    <i class="fa fa-save mr-1"></i> Submit Attendance
                </button>
            </div>
        </form>
    @endif

</div>

<script>
    const ratingMap = {
        1: 'Fair', 2: 'Fair', 3: 'Fair', 4: 'Fair',
        5: 'Good', 6: 'Good',
        7: 'Very Good', 8: 'Very Good',
        9: 'Excellent', 10: 'Excellent'
    };
    
    const ratingColors = {
        'Fair': 'bg-yellow-50 text-yellow-600',
        'Good': 'bg-green-50 text-green-600',
        'Very Good': 'bg-blue-50 text-blue-600',
        'Excellent': 'bg-emerald-50 text-emerald-600'
    };
    
    function updateRating(input, index) {
        const score = parseInt(input.value);
        let rating = '';
        let color = '';
        
        if (score >= 1 && score <= 10) {
            rating = ratingMap[score] || 'Not set';
            color = ratingColors[rating] || 'bg-gray-50 text-gray-600';
        } else if (score) {
            rating = 'Invalid (1-10)';
            color = 'bg-red-50 text-red-600';
        } else {
            rating = 'Not set';
            color = 'bg-gray-50 text-gray-600';
        }
        
        const ratingSpan = document.getElementById(`rating_${index}`);
        if (ratingSpan) {
            ratingSpan.textContent = rating;
            ratingSpan.className = `text-xs font-semibold px-3 py-1 rounded-full ${color}`;
        }
    }
    
    function confirmSubmit() {
        const scores = document.querySelectorAll('.attendance-score');
        let hasEntries = false;
        
        scores.forEach(score => {
            if (score.value && score.value !== '') {
                hasEntries = true;
            }
        });
        
        if (!hasEntries) {
            alert('No attendance scores entered. Please enter at least one score before submitting.');
            return;
        }
        
        if (confirm('⚠️ WARNING: Once submitted, attendance records CANNOT be edited or modified.\n\nAre you sure all scores are correct?\n\nClick OK to submit, Cancel to review.')) {
            document.getElementById('attendanceForm').submit();
        }
    }
</script>

@endsection