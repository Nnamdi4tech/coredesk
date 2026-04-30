@extends('layouts.admin')

@section('content')

@php $subdomain = request()->route('subdomain'); @endphp

<div class="w-full px-6 py-6 mx-auto">

    {{-- PAGE HEADER --}}
    <div class="flex flex-wrap items-center justify-between mb-6 -mx-3">
        <div class="px-3">
            <h3 class="text-2xl font-bold text-slate-700 mb-1">Bulk Result Entry</h3>
            <p class="text-sm text-slate-400">
                <i class="fa fa-home mr-1"></i> Dashboard
                <span class="mx-1 text-slate-300">/</span>
                <a href="{{ route('tenant.teacher.results.index', $subdomain) }}" class="hover:text-slate-600">Results</a>
                <span class="mx-1 text-slate-300">/</span>
                <span class="text-slate-600">Bulk Entry</span>
            </p>
        </div>
        <div class="px-3 mt-3 md:mt-0">
            <a href="{{ route('tenant.teacher.results.index', $subdomain) }}"
               class="px-4 py-2 text-sm border border-gray-300 rounded-lg text-slate-600 hover:bg-gray-50 transition-all">
                <i class="fa fa-arrow-left mr-1"></i> Back to Results
            </a>
        </div>
    </div>

    {{-- FLASH MESSAGES --}}
    @if(session('success'))
        <div class="p-4 mb-6 text-sm text-green-700 bg-green-50 border border-green-200 rounded-2xl flex items-center gap-3">
            <div class="w-8 h-8 rounded-lg bg-gradient-to-tl from-green-500 to-emerald-400 flex items-center justify-center flex-shrink-0">
                <i class="fa fa-check text-white text-xs"></i>
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
                <i class="fa fa-exclamation-circle text-white text-xs"></i>
            </div>
            <p class="font-semibold">{{ session('error') }}</p>
            <button onclick="this.parentElement.remove()" class="ml-auto text-red-400 hover:text-red-600">
                <i class="fa fa-times text-xs"></i>
            </button>
        </div>
    @endif

    {{-- SUBJECT SELECTOR CARD --}}
    <div class="bg-white shadow-soft-xl rounded-2xl p-6 mb-5">
        <div class="flex items-center gap-3 mb-4 pb-4 border-b border-gray-100">
            <div class="w-8 h-8 rounded-lg bg-gradient-to-tl from-blue-500 to-cyan-400 flex items-center justify-center shadow-soft-md">
                <i class="fa fa-book-open text-black text-xs"></i>
            </div>
            <div>
                <h6 class="font-bold text-slate-700 mb-0">Select Subject</h6>
                <p class="text-xs text-slate-400">Choose a subject to enter results for</p>
            </div>
        </div>
        <div class="max-w-sm">
            <label class="block text-xs font-semibold text-slate-600 mb-1.5">Subject</label>
            <select id="subject-select"
                    class="text-sm w-full rounded-lg border border-gray-300 bg-white py-2 px-3 text-gray-700 focus:outline-none focus:border-fuchsia-300 transition-all">
                <option value="">-- Select Subject --</option>
                @foreach($subjects as $subject)
                    <option value="{{ $subject->id }}" {{ $selectedSubject == $subject->id ? 'selected' : '' }}>
                        {{ $subject->name }}
                    </option>
                @endforeach
            </select>
            @if($subjects->isEmpty())
                <p class="text-xs text-amber-500 mt-2">
                    <i class="fa fa-exclamation-triangle mr-1"></i> No subjects assigned to you yet.
                </p>
            @endif
        </div>
    </div>

    {{-- LOADING SPINNER --}}
    <div id="subject-loading" class="hidden bg-white rounded-2xl shadow-soft-xl p-8 text-center mb-5">
        <div class="w-8 h-8 border-2 border-fuchsia-300 border-t-fuchsia-600 rounded-full animate-spin mx-auto mb-3"></div>
        <p class="text-sm text-slate-400">Loading students...</p>
    </div>

    {{-- FETCH ERROR --}}
    <div id="subject-fetch-error" class="hidden p-4 mb-5 text-sm text-red-700 bg-red-50 border border-red-200 rounded-2xl">
        <i class="fa fa-exclamation-circle mr-2"></i>
        <span id="subject-fetch-error-msg">Failed to load subject data. Please try again.</span>
    </div>

    {{-- DYNAMIC CONTENT AREA --}}
    <div id="bulk-content">
        <!-- [BULK-CONTENT-START] -->
        @if($selectedSubject)

        @php
            $isSubmitted = !empty($results) && (collect($results)->first()->submitted ?? false);
            $selectedSubjectName = $subjects->firstWhere('id', $selectedSubject)?->name ?? 'Selected Subject';
        @endphp

        @if($isSubmitted)
            <div class="p-4 mb-5 text-sm text-red-700 bg-red-50 border border-red-200 rounded-2xl flex items-center gap-3">
                <div class="w-8 h-8 rounded-lg bg-gradient-to-tl from-red-500 to-rose-400 flex items-center justify-center flex-shrink-0">
                    <i class="fa fa-lock text-white text-xs"></i>
                </div>
                <div>
                    <p class="font-semibold">Results Locked</p>
                    <p class="text-red-500 text-xs mt-0.5">Results for <strong>{{ $selectedSubjectName }}</strong> have been submitted and cannot be edited.</p>
                </div>
            </div>
        @endif

        <form id="bulk-form" method="POST" action="{{ route('tenant.teacher.results.bulk.store', $subdomain) }}">
        @csrf
        <input type="hidden" name="subject_id" value="{{ $selectedSubject }}">
        <input type="hidden" name="should_submit" id="should_submit" value="0">

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-5">
            <div>
                <label class="block text-xs font-semibold text-slate-600 mb-1.5">Term / Semester</label>
                <select name="term" required class="text-sm w-full rounded-lg border border-gray-300 py-2 px-3">
                    <option value="">-- Select Term --</option>
                    <option value="First Term">First Term</option>
                    <option value="Second Term">Second Term</option>
                    <option value="Third Term">Third Term</option>
                </select>
            </div>
            <div>
                <label class="block text-xs font-semibold text-slate-600 mb-1.5">Session</label>
                @php $year = date('Y'); @endphp
                <select name="session" required class="text-sm w-full rounded-lg border border-gray-300 py-2 px-3">
                    <option value="{{ $year }}/{{ $year + 1 }}">{{ $year }}/{{ $year + 1 }}</option>
                    <option value="{{ $year - 1 }}/{{ $year }}">{{ $year - 1 }}/{{ $year }}</option>
                </select>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-soft-xl overflow-hidden">

            <div class="flex flex-wrap items-center justify-between px-6 py-4 border-b border-gray-100 gap-3">
                <div>
                    <h6 class="font-bold text-slate-700">
                        {{ $selectedSubjectName }}
                        @if($isSubmitted)
                            <span class="ml-2 text-xs font-semibold bg-red-50 text-red-500 px-2 py-0.5 rounded-full"><i class="fa fa-lock mr-1"></i> Locked</span>
                        @else
                            <span class="ml-2 text-xs font-semibold bg-orange-50 text-orange-500 px-2 py-0.5 rounded-full"><i class="fa fa-pen mr-1"></i> Draft</span>
                        @endif
                    </h6>
                    <p class="text-xs text-slate-400 mt-0.5">{{ $students->count() }} {{ Str::plural('student', $students->count()) }}</p>
                </div>
                @if(!$isSubmitted)
                <div class="flex gap-3">
                    <button type="submit" class="px-5 py-2 text-sm font-semibold text-white rounded-lg bg-gradient-to-tl from-gray-900 to-slate-700 shadow-soft-md hover:shadow-soft-xl hover:scale-105 transition-all">
                        <i class="fa fa-save mr-1"></i> Save Only
                    </button>
                    <button type="button" onclick="bulkSubmitConfirm()"
                        class="px-5 py-2 text-sm font-semibold text-white rounded-lg bg-gradient-to-tl from-green-600 to-emerald-400 shadow-soft-md hover:shadow-soft-xl hover:scale-105 transition-all">
                        <i class="fa fa-check-circle mr-1"></i> Save & Submit Results
                    </button>
                </div>
                @endif
            </div>

            <div class="overflow-x-auto">
                <table class="items-center w-full mb-0 align-top border-gray-200 text-slate-500">
                    <thead class="align-bottom bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xxs font-bold uppercase tracking-wider text-slate-400 opacity-70">#</th>
                            <th class="px-6 py-3 text-left text-xxs font-bold uppercase tracking-wider text-slate-400 opacity-70">Student</th>
                            <th class="px-6 py-3 text-center text-xxs font-bold uppercase tracking-wider text-slate-400 opacity-70">CA1 <span class="text-slate-300 normal-case font-normal">/20</span></th>
                            <th class="px-6 py-3 text-center text-xxs font-bold uppercase tracking-wider text-slate-400 opacity-70">CA2 <span class="text-slate-300 normal-case font-normal">/20</span></th>
                            <th class="px-6 py-3 text-center text-xxs font-bold uppercase tracking-wider text-slate-400 opacity-70">Exam <span class="text-slate-300 normal-case font-normal">/60</span></th>
                            <th class="px-6 py-3 text-center text-xxs font-bold uppercase tracking-wider text-slate-400 opacity-70">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($students as $index => $student)
                        @php $result = $results[$student->id] ?? null; @endphp
                        <tr class="border-t border-gray-100 hover:bg-gray-50 transition-colors {{ ($result && $result->submitted) ? 'opacity-60' : '' }}">
                            <td class="px-6 py-3 align-middle"><span class="text-xs text-slate-400">{{ $index + 1 }}</span></td>
                            <td class="px-6 py-3 align-middle">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-xl bg-gradient-to-tl from-blue-500 to-cyan-400 flex items-center justify-center text-black text-xs font-bold shadow-soft-md flex-shrink-0">
                                        {{ strtoupper(substr($student->name, 0, 2)) }}
                                    </div>
                                    <div>
                                        <p class="text-sm font-semibold text-slate-700 mb-0">{{ $student->name }}</p>
                                        <p class="text-xs text-slate-400">{{ $student->student_id }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-3 align-middle text-center">
                                <input type="number" name="results[{{ $student->id }}][ca1]" value="{{ $result->ca1 ?? '' }}" min="0" max="20"
                                       {{ ($result && $result->submitted) ? 'disabled' : '' }}
                                       class="w-16 text-center text-sm rounded-lg border border-gray-200 py-1.5 px-2 focus:outline-none focus:border-fuchsia-300 transition-all {{ ($result && $result->submitted) ? 'bg-gray-50 text-gray-400 cursor-not-allowed' : 'bg-white' }}" />
                            </td>
                            <td class="px-6 py-3 align-middle text-center">
                                <input type="number" name="results[{{ $student->id }}][ca2]" value="{{ $result->ca2 ?? '' }}" min="0" max="20"
                                       {{ ($result && $result->submitted) ? 'disabled' : '' }}
                                       class="w-16 text-center text-sm rounded-lg border border-gray-200 py-1.5 px-2 focus:outline-none focus:border-fuchsia-300 transition-all {{ ($result && $result->submitted) ? 'bg-gray-50 text-gray-400 cursor-not-allowed' : 'bg-white' }}" />
                            </td>
                            <td class="px-6 py-3 align-middle text-center">
                                <input type="number" name="results[{{ $student->id }}][exam]" value="{{ $result->exam ?? '' }}" min="0" max="60"
                                       {{ ($result && $result->submitted) ? 'disabled' : '' }}
                                       class="w-16 text-center text-sm rounded-lg border border-gray-200 py-1.5 px-2 focus:outline-none focus:border-fuchsia-300 transition-all {{ ($result && $result->submitted) ? 'bg-gray-50 text-gray-400 cursor-not-allowed' : 'bg-white' }}" />
                            </td>
                            <td class="px-6 py-3 align-middle text-center">
                                @if($result && $result->submitted)
                                    <span class="text-xs font-semibold bg-green-50 text-green-600 px-2 py-1 rounded-full"><i class="fa fa-lock mr-1 text-xs"></i> Locked</span>
                                @elseif($result)
                                    <span class="text-xs font-semibold bg-orange-50 text-orange-500 px-2 py-1 rounded-full"><i class="fa fa-pen mr-1 text-xs"></i> Draft</span>
                                @else
                                    <span class="text-xs text-slate-300 italic">Not entered</span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            @if(!$isSubmitted)
            <div class="flex items-center justify-between px-6 py-4 border-t border-gray-100">
                <p class="text-xs text-slate-400">
                    Fill in scores and click <strong>Save Only</strong> to save as draft,
                    or <strong>Save & Submit Results</strong> to lock permanently.
                </p>
                <div class="flex gap-3">
                    <button type="submit" class="px-5 py-2 text-sm font-semibold text-white rounded-lg bg-gradient-to-tl from-gray-900 to-slate-700 shadow-soft-md hover:shadow-soft-xl hover:scale-105 transition-all">
                        <i class="fa fa-save mr-1"></i> Save Only
                    </button>
                    <button type="button" onclick="bulkSubmitConfirm()"
                        class="px-5 py-2 text-sm font-semibold text-white rounded-lg bg-gradient-to-tl from-green-600 to-emerald-400 shadow-soft-md hover:shadow-soft-xl hover:scale-105 transition-all">
                        <i class="fa fa-check-circle mr-1"></i> Save & Submit Results
                    </button>
                </div>
            </div>
            @else
            <div class="px-6 py-4 border-t border-gray-100 text-center">
                <p class="text-sm text-red-500 font-semibold">
                    <i class="fa fa-lock mr-1"></i> Results for {{ $selectedSubjectName }} have been submitted and are now locked.
                </p>
            </div>
            @endif

        </div>
        </form>

        @else

        <div class="bg-white rounded-2xl shadow-soft-xl p-12 text-center">
            <div class="w-16 h-16 rounded-2xl bg-gray-100 flex items-center justify-center mb-4 mx-auto">
                <i class="fa fa-book-open text-gray-400 text-2xl"></i>
            </div>
            <p class="text-slate-500 font-semibold">No subject selected</p>
            <p class="text-slate-400 text-sm mt-1">Select a subject above to start entering results</p>
        </div>

        @endif
        <!-- [BULK-CONTENT-END] -->
    </div>{{-- end #bulk-content --}}

</div>

<script>
function bulkSubmitConfirm() {
    var term    = document.querySelector('select[name="term"]').value;
    var session = document.querySelector('select[name="session"]').value;
    if (!term || !session) { alert('Please select Term and Session first.'); return; }
    if (confirm('⚠️ Results cannot be edited once submitted. Are you sure?')) {
        document.getElementById('should_submit').value = '1';
        document.getElementById('bulk-form').submit();
    }
}

(function () {
    const select  = document.getElementById('subject-select');
    const content = document.getElementById('bulk-content');
    const loading = document.getElementById('subject-loading');
    const errBox  = document.getElementById('subject-fetch-error');
    const errMsg  = document.getElementById('subject-fetch-error-msg');
    const csrf    = document.querySelector('meta[name="csrf-token"]')?.content ?? '';
    
    // Get the base URL without query parameters
    const baseUrl = '{{ route('tenant.teacher.results.bulk', $subdomain) }}';

    const emptyState = `<div class="bg-white rounded-2xl shadow-soft-xl p-12 text-center">
        <div class="w-16 h-16 rounded-2xl bg-gray-100 flex items-center justify-center mb-4 mx-auto">
            <i class="fa fa-book-open text-gray-400 text-2xl"></i>
        </div>
        <p class="text-slate-500 font-semibold">No subject selected</p>
        <p class="text-slate-400 text-sm mt-1">Select a subject above to start entering results</p>
    </div>`;

    async function loadSubject(id) {
        if (!id) {
            loading.classList.add('hidden');
            errBox.classList.add('hidden');
            content.innerHTML = emptyState;
            content.classList.remove('hidden');
            // Update URL without subject parameter
            const url = new URL(window.location.href);
            url.searchParams.delete('subject_id');
            window.history.replaceState(null, '', url.toString());
            return;
        }

        // Show loading, hide content
        content.classList.add('hidden');
        errBox.classList.add('hidden');
        loading.classList.remove('hidden');

        try {
            // Build URL with subject_id parameter
            const url = new URL(baseUrl, window.location.origin);
            url.searchParams.set('subject_id', id);
            url.searchParams.set('_ajax', '1');
            
            const resp = await fetch(url.toString(), {
                headers: { 
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': csrf,
                    'Accept': 'text/html'
                }
            });
            
            if (!resp.ok) throw new Error(`HTTP ${resp.status}`);
            
            const html = await resp.text();
            
            // Find the content between markers
            const startMarker = '<!-- [BULK-CONTENT-START] -->';
            const endMarker = '<!-- [BULK-CONTENT-END] -->';
            const startIdx = html.indexOf(startMarker);
            const endIdx = html.indexOf(endMarker);
            
            if (startIdx !== -1 && endIdx !== -1) {
                const innerHtml = html.substring(startIdx + startMarker.length, endIdx);
                content.innerHTML = innerHtml;
            } else {
                // Fallback: try to find bulk-content div
                const parser = new DOMParser();
                const doc = parser.parseFromString(html, 'text/html');
                const newContent = doc.getElementById('bulk-content');
                if (newContent) {
                    content.innerHTML = newContent.innerHTML;
                } else {
                    content.innerHTML = html;
                }
            }
            
            loading.classList.add('hidden');
            content.classList.remove('hidden');
            
            // Update URL with subject parameter
            const newUrl = new URL(window.location.href);
            newUrl.searchParams.set('subject_id', id);
            window.history.replaceState(null, '', newUrl.toString());
            
        } catch (e) {
            console.error('Fetch error:', e);
            loading.classList.add('hidden');
            errMsg.textContent = 'Could not load subject data. Please try again.';
            errBox.classList.remove('hidden');
            content.classList.add('hidden');
        }
    }

    select.addEventListener('change', function () { 
        loadSubject(this.value); 
    });
    
    // Load initial subject if already selected
    if (select.value) {
        loadSubject(select.value);
    }
})();
</script>

@endsection