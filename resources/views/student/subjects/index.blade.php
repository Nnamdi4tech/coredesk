@extends('layouts.admin')

@section('content')

@php $subdomain = request()->route('subdomain'); @endphp

<div class="w-full px-6 py-6 mx-auto">
    
    {{-- PAGE HEADER --}}
    <div class="flex flex-wrap items-center justify-between mb-6 -mx-3">
        <div class="px-3">
            <h3 class="text-2xl font-bold text-slate-700 mb-1">My Subjects</h3>
            <p class="text-sm text-slate-400">
                <i class="fa fa-home mr-1"></i> Dashboard
                <span class="mx-1 text-slate-300">/</span>
                <a href="{{ route('student.dashboard', $subdomain) }}" class="hover:text-slate-600">Student Portal</a>
                <span class="mx-1 text-slate-300">/</span>
                <span class="text-slate-600">My Subjects</span>
            </p>
        </div>
        <div class="px-3 mt-3 md:mt-0">
            <a href="{{ route('student.dashboard', $subdomain) }}"
               class="px-4 py-2 text-sm border border-gray-300 rounded-lg text-slate-600 hover:bg-gray-50 transition-all">
                <i class="fa fa-arrow-left mr-1"></i> Back to Dashboard
            </a>
        </div>
    </div>

    {{-- FILTER SECTION --}}
    <div class="bg-white shadow-soft-xl rounded-2xl p-4 mb-6">
        <div class="flex items-center justify-between mb-3 pb-2 border-b border-gray-100">
            <div class="flex items-center gap-2">
                <div class="w-6 h-6 rounded-lg bg-gradient-to-tl from-slate-600 to-slate-400 flex items-center justify-center">
                    <i class="fa fa-filter text-black text-xs"></i>
                </div>
                <div>
                    <h6 class="font-bold text-slate-700 text-sm">Filter Subjects</h6>
                    <p class="text-xs text-slate-400 hidden sm:block">
                        <i class="fa fa-info-circle mr-1 text-amber-400"></i>
                        Select class, term and session to view subject performance
                    </p>
                </div>
            </div>
            <button onclick="clearFilters()" class="text-xs text-slate-400 hover:text-slate-600 underline">
                Clear filters
            </button>
        </div>

        <div class="flex flex-wrap items-end gap-3">
            <div class="flex-1 min-w-[150px]">
                <label class="block text-xs font-semibold text-slate-500 mb-1">Class</label>
                <select id="classSelect" class="text-sm w-full rounded-lg border border-gray-300 bg-white py-2 px-3 focus:outline-none focus:border-fuchsia-300">
                    @foreach($allClasses as $class)
                        <option value="{{ $class->id }}" {{ $selectedClass == $class->id ? 'selected' : '' }}>
                            {{ $class->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="flex-1 min-w-[150px]">
                <label class="block text-xs font-semibold text-slate-500 mb-1">Term</label>
                <select id="termSelect" class="text-sm w-full rounded-lg border border-gray-300 bg-white py-2 px-3 focus:outline-none focus:border-fuchsia-300">
                    @foreach($availableTerms as $term)
                        <option value="{{ $term }}" {{ $selectedTerm == $term ? 'selected' : '' }}>
                            {{ $term }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="flex-1 min-w-[150px]">
                <label class="block text-xs font-semibold text-slate-500 mb-1">Session</label>
                <select id="sessionSelect" class="text-sm w-full rounded-lg border border-gray-300 bg-white py-2 px-3 focus:outline-none focus:border-fuchsia-300">
                    @foreach($availableSessions as $session)
                        <option value="{{ $session }}" {{ $selectedSession == $session ? 'selected' : '' }}>
                            {{ $session }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <button onclick="applyFilters()"
                        class="px-5 py-2 text-sm font-semibold text-black rounded-lg bg-gradient-to-tl from-blue-600 to-cyan-500 shadow-soft-md hover:shadow-soft-xl transition-all">
                    <i class="fa fa-search mr-1"></i> Apply
                </button>
            </div>
        </div>
    </div>

    {{-- Subjects Card --}}
    <div class="bg-white shadow-soft-xl rounded-2xl overflow-hidden">
        
        <div class="flex items-center gap-3 px-6 py-4 border-b border-gray-100">
            <div class="w-8 h-8 rounded-lg bg-gradient-to-tl from-purple-500 to-pink-400 flex items-center justify-center shadow-soft-md">
                <i class="fa fa-book-open text-black text-xs"></i>
            </div>
            <div>
                <h6 class="font-bold text-slate-700 mb-0">Subjects Offered</h6>
                <p class="text-xs text-slate-400 mt-0.5" id="infoText">
                    {{ $student->name ?? 'Student' }} | Class: <strong id="currentClass">{{ $selectedClassName }}</strong> | 
                    Term: <strong id="currentTerm">{{ $selectedTerm }}</strong> | Session: <strong id="currentSession">{{ $selectedSession }}</strong>
                </p>
            </div>
        </div>

        {{-- LOADING INDICATOR --}}
        <div id="loadingIndicator" class="hidden text-center py-8">
            <div class="inline-block w-8 h-8 border-4 border-blue-500 border-t-transparent rounded-full animate-spin"></div>
            <p class="text-sm text-slate-500 mt-2">Loading subjects...</p>
        </div>

        {{-- Subjects Grid Container --}}
        <div id="subjectsGrid">
            @if($subjects->isEmpty())
                <div class="p-12 text-center">
                    <div class="w-20 h-20 rounded-2xl bg-gray-100 flex items-center justify-center mb-4 mx-auto">
                        <i class="fa fa-book-open text-gray-400 text-3xl"></i>
                    </div>
                    <p class="text-slate-500 font-semibold text-lg">No subjects found</p>
                    <p class="text-slate-400 text-sm mt-1">Your subjects will appear here once assigned by your teacher.</p>
                </div>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 p-6">
                    @foreach($subjects as $subject)
                        @php
                            $cardBg = $subject->has_result 
                                ? 'bg-gradient-to-r from-green-50 to-emerald-50 border-green-200' 
                                : 'bg-gradient-to-r from-blue-50 to-cyan-50 border-blue-100';
                            $iconBg = $subject->has_result 
                                ? 'bg-gradient-to-tl from-green-500 to-emerald-400' 
                                : 'bg-gradient-to-tl from-blue-500 to-cyan-400';
                        @endphp
                        <div class="relative flex flex-col min-w-0 break-words {{ $cardBg }} rounded-xl border hover:shadow-soft-md transition-all group">
                            <div class="flex-auto p-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-lg {{ $iconBg }} flex items-center justify-center shadow-soft-sm group-hover:scale-110 transition-all">
                                        <i class="fa fa-book text-black text-sm"></i>
                                    </div>
                                    <div class="flex-1">
                                        <h5 class="font-bold text-slate-700 mb-0">{{ $subject->name }}</h5>
                                        <p class="text-xs text-slate-500 mt-0.5">Course Code: {{ $subject->course_code ?? 'N/A' }}</p>
                                    </div>
                                    @if($subject->has_result)
                                        <div class="text-right">
                                            <span class="inline-flex items-center justify-center w-10 h-10 text-lg font-bold rounded-full 
                                                {{ $subject->result_grade == 'A' ? 'bg-green-100 text-green-600' : 
                                                   ($subject->result_grade == 'B' ? 'bg-blue-100 text-blue-600' :
                                                   ($subject->result_grade == 'C' ? 'bg-yellow-100 text-yellow-600' :
                                                   ($subject->result_grade == 'D' ? 'bg-orange-100 text-orange-600' :
                                                   ($subject->result_grade == 'E' ? 'bg-purple-100 text-purple-600' : 'bg-red-100 text-red-600')))) }}">
                                                {{ $subject->result_grade }}
                                            </span>
                                            <p class="text-xs text-slate-500 mt-1">{{ $subject->result_total }}%</p>
                                        </div>
                                    @else
                                        <div class="text-right">
                                            <span class="text-xs px-2 py-1 rounded-full bg-gray-100 text-gray-500">
                                                Pending
                                            </span>
                                        </div>
                                    @endif
                                </div>
                                @if($subject->has_result)
                                    <div class="mt-3 pt-2 border-t border-gray-200">
                                        <div class="flex justify-between items-center">
                                            <span class="text-xs text-slate-500">Performance</span>
                                            <span class="text-xs font-semibold text-green-600">
                                                <i class="fa fa-check-circle mr-1"></i> Results Published
                                            </span>
                                        </div>
                                        <div class="mt-2 w-full bg-gray-200 rounded-full h-1.5">
                                            <div class="bg-green-500 h-1.5 rounded-full" style="width: {{ $subject->result_total ?? 0 }}%"></div>
                                        </div>
                                        @if($subject->result_remark)
                                            <p class="text-xs text-slate-500 mt-2">{{ $subject->result_remark }}</p>
                                        @endif
                                    </div>
                                @else
                                    <div class="mt-3 pt-2 border-t border-gray-200">
                                        <p class="text-xs text-amber-600 flex items-center gap-1">
                                            <i class="fa fa-clock-o"></i> Results not yet published for {{ $selectedTerm }}
                                        </p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>

    {{-- Footer Note --}}
    <div class="mt-5 p-4 bg-gradient-to-r from-blue-50 to-cyan-50 rounded-xl border border-blue-100">
        <div class="flex items-start gap-3">
            <div class="w-8 h-8 rounded-lg bg-gradient-to-tl from-blue-500 to-cyan-400 flex items-center justify-center flex-shrink-0 shadow-soft-sm">
                <i class="fa fa-info-circle text-black text-xs"></i>
            </div>
            <div>
                <p class="text-sm font-semibold text-blue-800">Subject Information</p>
                <p class="text-xs text-blue-600 mt-0.5">
                    These are the subjects assigned to your class for the selected term and session. 
                    Green highlighted subjects have published results. For any missing subjects, please contact your class teacher.
                </p>
            </div>
        </div>
    </div>

</div>

<script>
    function applyFilters() {
    const classId = document.getElementById('classSelect').value;
    const term = document.getElementById('termSelect').value;
    const session = document.getElementById('sessionSelect').value;
    const loadingIndicator = document.getElementById('loadingIndicator');
    const subjectsGrid = document.getElementById('subjectsGrid');
    const currentClassSpan = document.getElementById('currentClass');
    const currentTermSpan = document.getElementById('currentTerm');
    const currentSessionSpan = document.getElementById('currentSession');
    
    // Show loading indicator
    loadingIndicator.classList.remove('hidden');
    subjectsGrid.classList.add('opacity-50');
    
    // Get selected class name
    const classSelect = document.getElementById('classSelect');
    const selectedClassName = classSelect.options[classSelect.selectedIndex].text;
    
    fetch(`{{ route('student.subjects', $subdomain) }}?class_id=${encodeURIComponent(classId)}&term=${encodeURIComponent(term)}&session=${encodeURIComponent(session)}&_ajax=1`, {
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'text/html'
        }
    })
    .then(response => {
        if (!response.ok) {
            return response.json().then(err => { throw err; });
        }
        return response.text();
    })
    .then(html => {
        const parser = new DOMParser();
        const doc = parser.parseFromString(html, 'text/html');
        const newGrid = doc.getElementById('subjectsGrid');
        
        if (newGrid) {
            subjectsGrid.innerHTML = newGrid.innerHTML;
        } else {
            subjectsGrid.innerHTML = html;
        }
        
        currentClassSpan.textContent = selectedClassName;
        currentTermSpan.textContent = term;
        currentSessionSpan.textContent = session;
        loadingIndicator.classList.add('hidden');
        subjectsGrid.classList.remove('opacity-50');
    })
    .catch(error => {
        console.error('Error:', error);
        loadingIndicator.classList.add('hidden');
        subjectsGrid.classList.remove('opacity-50');

        if (error.error) {
            alert(error.error);
        } else {
            alert('Not a member of this class. Contact admin.');
        }
    });
}
    
    function clearFilters() {
        // Reset to student's default class
        const defaultClass = '{{ $student->class_id }}';
        document.getElementById('classSelect').value = defaultClass;
        document.getElementById('termSelect').value = 'First Term';
        document.getElementById('sessionSelect').value = '{{ $availableSessions[0] ?? date("Y") . "/" . (date("Y") + 1) }}';
        applyFilters();
    }
</script>

@endsection