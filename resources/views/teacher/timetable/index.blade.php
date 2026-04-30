@extends('layouts.admin')

@section('content')

@php $subdomain = request()->route('subdomain'); @endphp

<div class="w-full px-6 py-6 mx-auto">
    
    {{-- PAGE HEADER --}}
    <div class="flex flex-wrap items-center justify-between mb-6 -mx-3">
        <div class="px-3">
            <h3 class="text-2xl font-bold text-slate-700 mb-1">My Timetable</h3>
            <p class="text-sm text-slate-400">
                <i class="fa fa-home mr-1"></i> Dashboard
                <span class="mx-1 text-slate-300">/</span>
                <span class="text-slate-600">Timetable</span>
            </p>
        </div>
        <div class="px-3 mt-3 md:mt-0">
            <a href="#"
               class="px-4 py-2 text-sm border border-gray-300 rounded-lg text-slate-600 hover:bg-gray-50 transition-all">
                <i class="fa fa-chalkboard-user mr-1 fa-flip"></i> My Workspace
                
            </a>
        </div>
    </div>

    {{-- Timetable Card --}}
    <div class="bg-white shadow-soft-xl rounded-2xl overflow-hidden">
        
        <div class="flex items-center gap-3 px-6 py-4 border-b border-gray-100">
            <div class="w-8 h-8 rounded-lg bg-gradient-to-tl from-purple-500 to-pink-400 flex items-center justify-center shadow-soft-md">
                <i class="fa fa-calendar-alt text-black text-xs"></i>
            </div>
            <div>
                <h6 class="font-bold text-slate-700 mb-0">Class Schedule</h6>
                <p class="text-xs text-slate-400 mt-0.5">Your teaching timetable</p>
            </div>
        </div>

        {{-- LIVE FILTER SECTION --}}
        <div class="px-6 py-4 border-b border-gray-100 bg-gray-50">
            <div class="flex flex-wrap items-end gap-4">
                <div class="flex-1 min-w-[150px]">
                    <label class="block text-xs font-semibold text-slate-600 mb-1.5">
                        <i class="fa fa-search mr-1 text-slate-400"></i> Search
                    </label>
                    <input type="text" 
                           id="searchInput"
                           placeholder="Search by day, class, subject, teacher..."
                           class="text-sm w-full rounded-lg border border-gray-300 bg-white py-2 px-3 text-gray-700 focus:outline-none focus:border-fuchsia-300 transition-all">
                </div>

                <div class="flex-1 min-w-[150px]">
                    <label class="block text-xs font-semibold text-slate-600 mb-1.5">
                        <i class="fa fa-calendar-day mr-1 text-slate-400"></i> Day
                    </label>
                    <select id="dayFilter" 
                            class="text-sm w-full rounded-lg border border-gray-300 bg-white py-2 px-3 text-gray-700 focus:outline-none focus:border-fuchsia-300 transition-all">
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

                <div class="flex-1 min-w-[150px]">
                    <label class="block text-xs font-semibold text-slate-600 mb-1.5">
                        <i class="fa fa-calendar-alt mr-1 text-slate-400"></i> Term
                    </label>
                    <select id="termFilter" 
                            class="text-sm w-full rounded-lg border border-gray-300 bg-white py-2 px-3 text-gray-700 focus:outline-none focus:border-fuchsia-300 transition-all">
                        <option value="">All Terms</option>
                        <option value="First">First Term</option>
                        <option value="Second">Second Term</option>
                        <option value="Third">Third Term</option>
                    </select>
                </div>

                <div class="flex-1 min-w-[150px]">
                    <label class="block text-xs font-semibold text-slate-600 mb-1.5">
                        <i class="fa fa-calendar-week mr-1 text-slate-400"></i> Session
                    </label>
                    <input type="text" 
                           id="sessionFilter"
                           placeholder="e.g. 2024/2025"
                           class="text-sm w-full rounded-lg border border-gray-300 bg-white py-2 px-3 text-gray-700 focus:outline-none focus:border-fuchsia-300 transition-all">
                </div>

                <div>
                    <button onclick="clearFilters()"
                            class="px-5 py-2 text-sm font-semibold text-slate-600 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition-all">
                        <i class="fa fa-times mr-1"></i> Clear
                    </button>
                </div>
            </div>
            
            {{-- Results count --}}
            <div class="mt-3 text-right">
                <p class="text-xs text-slate-400">
                    Showing <span id="visibleCount" class="font-bold text-slate-600">{{ $timetables->count() }}</span> of {{ $timetables->count() }} entries
                </p>
            </div>
        </div>

        {{-- No results message --}}
        <div id="noResults" class="p-12 text-center hidden">
            <div class="w-20 h-20 rounded-2xl bg-gray-100 flex items-center justify-center mb-4 mx-auto">
                <i class="fa fa-search text-gray-400 text-3xl"></i>
            </div>
            <p class="text-slate-500 font-semibold text-lg">No matching entries</p>
            <p class="text-slate-400 text-sm mt-1">Try adjusting your filters.</p>
        </div>

        @if($timetables->count() > 0)
            <div class="overflow-x-auto w-full">
                <table class="w-full min-w-[800px] mb-0 align-top border-gray-200 text-slate-500" id="timetableTable">
                    <thead class="align-bottom bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xxs font-bold uppercase tracking-wider text-slate-400 opacity-70">Day</th>
                            <th class="px-6 py-3 text-left text-xxs font-bold uppercase tracking-wider text-slate-400 opacity-70">Class</th>
                            <th class="px-6 py-3 text-left text-xxs font-bold uppercase tracking-wider text-slate-400 opacity-70">Subject</th>
                            <th class="px-6 py-3 text-left text-xxs font-bold uppercase tracking-wider text-slate-400 opacity-70">Teacher</th>
                            <th class="px-6 py-3 text-center text-xxs font-bold uppercase tracking-wider text-slate-400 opacity-70">Time</th>
                            <th class="px-6 py-3 text-center text-xxs font-bold uppercase tracking-wider text-slate-400 opacity-70">Term/Semester</th>
                            <th class="px-6 py-3 text-center text-xxs font-bold uppercase tracking-wider text-slate-400 opacity-70">Session</th>
                        </tr>
                    </thead>
                    <tbody id="timetableBody">
                        @foreach($timetables as $timetable)
                        @php
                            $dayColors = [
                                'Monday' => 'bg-blue-50 text-blue-600',
                                'Tuesday' => 'bg-indigo-50 text-indigo-600',
                                'Wednesday' => 'bg-purple-50 text-purple-600',
                                'Thursday' => 'bg-green-50 text-green-600',
                                'Friday' => 'bg-amber-50 text-amber-600',
                                'Saturday' => 'bg-orange-50 text-orange-600',
                                'Sunday' => 'bg-red-50 text-red-600',
                            ];
                            $dayColor = $dayColors[$timetable->day] ?? 'bg-gray-50 text-gray-600';
                            
                            // Convert term for filtering (First -> 1st, Second -> 2nd, Third -> 3rd)
                            $termNumber = '';
                            if ($timetable->term == 'First') $termNumber = '1st';
                            elseif ($timetable->term == 'Second') $termNumber = '2nd';
                            elseif ($timetable->term == 'Third') $termNumber = '3rd';
                        @endphp
                        <tr class="timetable-row border-t border-gray-100 hover:bg-gray-50 transition-colors"
                            data-day="{{ $timetable->day ?? '' }}"
                            data-class="{{ $timetable->class->name ?? '' }}"
                            data-subject="{{ $timetable->subject->name ?? '' }}"
                            data-teacher="{{ $timetable->teacher->name ?? '' }}"
                            data-term="{{ $timetable->term ?? '' }}"
                            data-term-number="{{ $termNumber }}"
                            data-session="{{ $timetable->session ?? '' }}">
                            <td class="px-6 py-4 align-middle">
                                <div class="flex items-center gap-2">
                                    <div class="w-6 h-6 rounded-lg bg-gradient-to-tl from-purple-500 to-pink-400 flex items-center justify-center">
                                        <i class="fa fa-calendar-day text-black text-xs"></i>
                                    </div>
                                    <span class="px-3 py-1 text-xs font-semibold rounded-full {{ $dayColor }}">
                                        {{ $timetable->day }}
                                    </span>
                                </div>
                            </td>
                            <td class="px-6 py-4 align-middle">
                                <div class="flex items-center gap-2">
                                    <div class="w-6 h-6 rounded-lg bg-gradient-to-tl from-blue-500 to-cyan-400 flex items-center justify-center">
                                        <i class="fa fa-chalkboard text-black text-xs"></i>
                                    </div>
                                    <span class="text-sm font-semibold text-slate-700">{{ $timetable->class->name ?? 'N/A' }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4 align-middle">
                                <div class="flex items-center gap-2">
                                    <div class="w-6 h-6 rounded-lg bg-gradient-to-tl from-indigo-500 to-purple-400 flex items-center justify-center">
                                        <i class="fa fa-book text-black text-xs"></i>
                                    </div>
                                    <span class="text-sm text-slate-600">{{ $timetable->subject->name ?? 'N/A' }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4 align-middle">
                                <div class="flex items-center gap-2">
                                    <div class="w-6 h-6 rounded-lg bg-gradient-to-tl from-green-500 to-emerald-400 flex items-center justify-center">
                                        <i class="fa fa-chalkboard-user text-black text-xs"></i>
                                    </div>
                                    <span class="text-sm text-slate-600">{{ $timetable->teacher->name ?? 'N/A' }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4 align-middle text-center">
                                <div class="flex items-center justify-center gap-1">
                                    <i class="fa fa-clock text-slate-400 text-xs"></i>
                                    <span class="text-sm text-slate-600">{{ $timetable->start_time }} - {{ $timetable->end_time }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4 align-middle text-center">
                                <span class="px-3 py-1 text-xs font-semibold rounded-full bg-purple-50 text-purple-600">
                                    {{ $timetable->term ?? 'N/A' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 align-middle text-center">
                                <span class="px-3 py-1 text-xs font-semibold rounded-full bg-cyan-50 text-cyan-600">
                                    {{ $timetable->session ?? 'N/A' }}
                                </span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="p-12 text-center">
                <div class="w-20 h-20 rounded-2xl bg-gray-100 flex items-center justify-center mb-4 mx-auto">
                    <i class="fa fa-calendar-alt text-gray-400 text-3xl"></i>
                </div>
                <p class="text-slate-500 font-semibold text-lg">No timetable found</p>
                <p class="text-slate-400 text-sm mt-1">No timetable entries match your criteria.</p>
            </div>
        @endif

    </div>

    {{-- Footer Note --}}
    <div class="mt-5 p-4 bg-gradient-to-r from-blue-50 to-cyan-50 rounded-xl border border-blue-100">
        <div class="flex items-start gap-3">
            <div class="w-8 h-8 rounded-lg bg-gradient-to-tl from-blue-500 to-cyan-400 flex items-center justify-center flex-shrink-0">
                <i class="fa fa-info-circle text-black text-xs"></i>
            </div>
            <div>
                <p class="text-sm font-semibold text-blue-800">Timetable Information</p>
                <p class="text-xs text-blue-600 mt-0.5">
                    This timetable shows all your assigned classes. Use filters to narrow down by day, term, or session.
                </p>
            </div>
        </div>
    </div>

</div>

<script>
// Get DOM elements
const searchInput = document.getElementById('searchInput');
const dayFilter = document.getElementById('dayFilter');
const termFilter = document.getElementById('termFilter');
const sessionFilter = document.getElementById('sessionFilter');
const rows = document.querySelectorAll('.timetable-row');
const noResults = document.getElementById('noResults');
const visibleCount = document.getElementById('visibleCount');
const timetableTable = document.getElementById('timetableTable');

function applyFilters() {
    const searchTerm = searchInput.value.toLowerCase();
    const selectedDay = dayFilter.value.toLowerCase();
    const selectedTerm = termFilter.value.toLowerCase();
    const selectedSession = sessionFilter.value.toLowerCase();
    
    let visible = 0;

    rows.forEach(row => {
        const rowDay = row.dataset.day.toLowerCase();
        const rowClass = row.dataset.class.toLowerCase();
        const rowSubject = row.dataset.subject.toLowerCase();
        const rowTeacher = row.dataset.teacher.toLowerCase();
        const rowTerm = row.dataset.term.toLowerCase();
        const rowTermNumber = row.dataset.termNumber.toLowerCase();
        const rowSession = row.dataset.session.toLowerCase();
        
        // Combine all text for search
        const fullText = `${rowDay} ${rowClass} ${rowSubject} ${rowTeacher} ${rowTerm} ${rowTermNumber} ${rowSession}`.toLowerCase();
        
        // Check search match (supports "1st", "2nd", "3rd" for terms)
        const matchesSearch = searchTerm === '' || fullText.includes(searchTerm);
        
        // Check day filter
        const matchesDay = selectedDay === '' || rowDay === selectedDay;
        
        // Check term filter (supports both "First" and "1st" etc.)
        let matchesTerm = selectedTerm === '';
        if (!matchesTerm) {
            matchesTerm = rowTerm === selectedTerm || rowTermNumber === selectedTerm;
        }
        
        // Check session filter
        const matchesSession = selectedSession === '' || rowSession.includes(selectedSession);
        
        // Show/hide row
        if (matchesSearch && matchesDay && matchesTerm && matchesSession) {
            row.style.display = '';
            visible++;
        } else {
            row.style.display = 'none';
        }
    });
    
    // Update visible count
    visibleCount.textContent = visible;
    
    // Show/hide no results message
    if (visible === 0) {
        noResults.classList.remove('hidden');
        if (timetableTable) timetableTable.style.display = 'none';
    } else {
        noResults.classList.add('hidden');
        if (timetableTable) timetableTable.style.display = '';
    }
}

function clearFilters() {
    searchInput.value = '';
    dayFilter.value = '';
    termFilter.value = '';
    sessionFilter.value = '';
    applyFilters();
}

// Add event listeners
searchInput.addEventListener('keyup', applyFilters);
dayFilter.addEventListener('change', applyFilters);
termFilter.addEventListener('change', applyFilters);
sessionFilter.addEventListener('keyup', applyFilters);

// Initial apply (in case of any pre-filled values)
applyFilters();
</script>

@endsection