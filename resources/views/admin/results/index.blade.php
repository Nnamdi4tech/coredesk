@extends('layouts.admin')

@section('content')

@php $subdomain = request()->route('subdomain'); @endphp

<div class="w-full px-6 py-6 mx-auto">

    {{-- PAGE HEADER --}}
    <div class="flex flex-wrap items-center justify-between mb-6 -mx-3">
        <div class="px-3">
            <h3 class="text-2xl font-bold text-slate-700 mb-1">Submitted Results for Review</h3>
            <p class="text-sm text-slate-400">
                <i class="fa fa-home mr-1"></i> Dashboard
                <span class="mx-1 text-slate-300">/</span>
                <span class="text-slate-600">Results Review</span>
            </p>
        </div>
    </div>

    {{-- SUCCESS / ERROR MESSAGES --}}
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

    <!-- filter -->
     {{-- FILTER BAR --}}
<div class="bg-white shadow-soft-xl rounded-2xl px-6 py-4 mb-5">
    <form id="filterForm" class="flex flex-wrap items-end gap-3">
        <div class="flex flex-col gap-1 flex-1 min-w-[160px]">
            <label class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Teacher</label>
            <input
                type="text"
                name="teacher"
                value="{{ request('teacher') }}"
                placeholder="Search teacher..."
                class="text-sm border border-gray-200 rounded-lg px-3 py-2 focus:outline-none focus:border-blue-400 text-slate-700"
            />
        </div>
        <div class="flex flex-col gap-1 flex-1 min-w-[160px]">
            <label class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Subject</label>
            <input
                type="text"
                name="subject"
                value="{{ request('subject') }}"
                placeholder="Search subject..."
                class="text-sm border border-gray-200 rounded-lg px-3 py-2 focus:outline-none focus:border-blue-400 text-slate-700"
            />
        </div>
        <div class="flex flex-col gap-1 flex-1 min-w-[160px]">
            <label class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Date</label>
            <input
                type="date"
                name="date"
                value="{{ request('date') }}"
                class="text-sm border border-gray-200 rounded-lg px-3 py-2 focus:outline-none focus:border-blue-400 text-slate-700"
            />
        </div>
        <div class="flex gap-2">
            <button type="submit"
                class="inline-flex items-center gap-1.5 px-4 py-2 text-xs font-semibold text-white rounded-lg bg-gradient-to-tl from-blue-600 to-cyan-500 shadow-soft-sm hover:scale-105 transition-all">
                <i class="fa fa-search text-xs"></i> Filter
            </button>
            <button type="button" id="clearFilter"
                class="inline-flex items-center gap-1.5 px-4 py-2 text-xs font-semibold text-slate-600 rounded-lg border border-gray-200 hover:bg-gray-50 transition-all">
                <i class="fa fa-times text-xs"></i> Clear
            </button>
        </div>
    </form>
</div>

    {{-- RESULTS TABLE CARD --}}
<div id="resultsWrapper" class="bg-white shadow-soft-xl rounded-2xl overflow-hidden">
    
    @if($results->count() > 0)
        {{-- Table Header with Stats --}}
        <div class="flex flex-wrap items-center justify-between px-6 py-4 border-b border-gray-100 gap-3">
            <div>
                <h6 class="font-bold text-slate-700">
                    Submitted Results for Review
                </h6>
                <p class="text-xs text-slate-400 mt-0.5">
                    <span class="font-semibold text-orange-600">{{ $totalNeedsAttention }}</span> result(s) need attention across 
                    <span class="font-semibold text-blue-600">{{ $subjectsNeedingAttention }}</span> subject(s)
                </p>
                <div class="flex gap-3 mt-2">
                    <span class="text-xs text-slate-500">
                        <i class="fa fa-clock text-orange-500 mr-1"></i> Pending: {{ $pendingOnly }}
                    </span>
                    <span class="text-xs text-slate-500">
                        <i class="fa fa-undo text-amber-500 mr-1"></i> Needs Revision: {{ $needsRevision }}
                    </span>
                    <span class="text-xs text-slate-500">
                        <i class="fa fa-check-circle text-green-500 mr-1"></i> Approved: {{ $approvedCount }}
                    </span>
                </div>
            </div>
            
            {{-- Badge Stats --}}
            <div class="flex gap-2">
                <span class="px-3 py-1 text-xs font-semibold rounded-full bg-orange-50 text-orange-600">
                    <i class="fa fa-clock mr-1"></i> Pending: {{ $pendingOnly }}
                </span>
                <span class="px-3 py-1 text-xs font-semibold rounded-full bg-amber-50 text-amber-600">
                    <i class="fa fa-undo mr-1"></i> Needs Revision: {{ $needsRevision }}
                </span>
                <span class="px-3 py-1 text-xs font-semibold rounded-full bg-green-50 text-green-600">
                    <i class="fa fa-check-circle mr-1"></i> Approved: {{ $approvedCount }}
                </span>
            </div>
        </div>

        {{-- Table --}}
        <div class="overflow-x-auto">
            <table class="items-center w-full mb-0 align-top border-gray-200 text-slate-500">
                <thead class="align-bottom bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xxs font-bold uppercase tracking-wider text-slate-400 opacity-70">
                            <i class="fa fa-book-open mr-1"></i> Subject
                        </th>
                        <th class="px-6 py-3 text-left text-xxs font-bold uppercase tracking-wider text-slate-400 opacity-70">
                            <i class="fa fa-chalkboard-user mr-1"></i> Teacher
                        </th>
                        <th class="px-6 py-3 text-left text-xxs font-bold uppercase tracking-wider text-slate-400 opacity-70">
                            <i class="fa fa-flag-checkered mr-1"></i> Status
                        </th>
                        <th class="px-6 py-3 text-center text-xxs font-bold uppercase tracking-wider text-slate-400 opacity-70">
                            <i class="fa fa-cog mr-1"></i> Actions
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($results as $result)
                    <tr class="border-t border-gray-100 hover:bg-gray-50 transition-colors">
                        
                        {{-- Subject --}}
                        <td class="px-6 py-4 align-middle">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-xl bg-gradient-to-tl from-purple-500 to-pink-400 flex items-center justify-center text-primary text-xs font-bold shadow-soft-md flex-shrink-0">
                                    {{ strtoupper(substr($result->subject->name ?? 'N/A', 0, 2)) }}
                                </div>
                                <div>
                                    <p class="text-sm font-semibold text-slate-700 mb-0">
                                        {{ $result->subject->name ?? 'N/A' }}
                                    </p>
                                    <!-- <p class="text-xs text-slate-400">
                                        ID: {{ $result->subject_id ?? 'N/A' }}
                                    </p> -->
                                </div>
                            </div>
                        </td>

                        {{-- Teacher --}}
                        <td class="px-6 py-4 align-middle">
                            <div class="flex items-center gap-2">
                                <div class="w-6 h-6 rounded-full bg-gradient-to-tl from-blue-500 to-cyan-400 flex items-center justify-center text-primary text-xs font-bold flex-shrink-0">
                                    {{ strtoupper(substr($result->teacher->name ?? 'N/A', 0, 1)) }}
                                </div>
                                <span class="text-sm text-slate-600">
                                    {{ $result->teacher->name ?? 'N/A' }}
                                </span>
                            </div>
                        </td>

                        {{-- Status --}}
                        <td class="px-6 py-4 align-middle">
                            @if($result->approved_in_group == $result->total_students)
                                <span class="inline-flex items-center gap-1.5 text-xs font-semibold bg-green-50 text-green-600 px-2.5 py-1 rounded-full">
                                    <i class="fa fa-check-circle text-xs"></i>
                                    Fully Approved
                                </span>
                            @elseif($result->rejected_in_group == $result->total_students)
                                <span class="inline-flex items-center gap-1.5 text-xs font-semibold bg-amber-50 text-amber-600 px-2.5 py-1 rounded-full">
                                    <i class="fa fa-undo text-xs"></i>
                                    Needs Revision
                                </span>
                            @elseif($result->pending_in_group > 0)
                                <span class="inline-flex items-center gap-1.5 text-xs font-semibold bg-orange-50 text-orange-600 px-2.5 py-1 rounded-full">
                                    <i class="fa fa-clock text-xs"></i>
                                    {{ $result->approved_in_group }}/{{ $result->total_students }} Approved
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1.5 text-xs font-semibold bg-blue-50 text-blue-600 px-2.5 py-1 rounded-full">
                                    <i class="fa fa-chart-simple text-xs"></i>
                                    {{ $result->approved_in_group }} Approved, {{ $result->rejected_in_group }} Needs Revision
                                </span>
                            @endif

                            {{-- ✅ DATE --}}
    <p class="text-xs text-slate-400 mt-1">
        {{ \Carbon\Carbon::parse($result->created_at)->format('d M Y') }}
    </p>
                        </td>

                        {{-- Actions --}}
                        <td class="px-6 py-4 align-middle text-center">
                            <a href="{{ route('tenant.admin.results.show', [$subdomain, $result->subject_id, $result->class_id]) }}" 
                               class="inline-flex items-center gap-1.5 px-4 py-1.5 text-xs font-semibold text-white rounded-lg bg-gradient-to-tl from-blue-600 to-cyan-500 shadow-soft-sm hover:shadow-soft-md hover:scale-105 transition-all">
                                <i class="fa fa-eye text-xs"></i>
                                View Details
                            </a>
                        </td>

                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- Optional: Pagination --}}
        @if(method_exists($results, 'links'))
            <div class="px-6 py-4 border-t border-gray-100">
                {{ $results->links() }}
            </div>
        @endif

    @else
        {{-- Empty State --}}
        <div class="p-12 text-center">
            <div class="w-20 h-20 rounded-2xl bg-gray-100 flex items-center justify-center mb-4 mx-auto">
                <i class="fa fa-inbox text-gray-400 text-3xl"></i>
            </div>
            <p class="text-slate-500 font-semibold text-lg">No submissions to review</p>
            <p class="text-slate-400 text-sm mt-1">
                When teachers submit results, they will appear here for approval.
            </p>
            <div class="mt-4">
                <span class="inline-flex items-center gap-2 text-xs text-slate-400 bg-gray-50 px-4 py-2 rounded-full">
                    <i class="fa fa-check-circle text-green-500"></i>
                    All results are approved
                </span>
            </div>
        </div>
    @endif

</div>

{{-- Info Card --}}
<div class="mt-5 p-4 bg-gradient-to-r from-blue-50 to-cyan-50 rounded-xl border border-blue-100">
    <div class="flex items-start gap-3">
        <div class="w-8 h-8 rounded-lg bg-gradient-to-tl from-blue-500 to-cyan-400 flex items-center justify-center flex-shrink-0 shadow-soft-sm">
            <i class="fa fa-info-circle text-black text-xs"></i>
        </div>
        <div>
            <p class="text-sm font-semibold text-blue-800">Review Process</p>
            <p class="text-xs text-blue-600 mt-0.5">
                Click <strong>View Details</strong> to review individual student scores. You can approve or reject the entire submission for each subject. Once approved, results become final and cannot be modified by teachers.
            </p>
        </div>
    </div>
</div>

<script>
function loadPage(url) {
    const wrapper = document.getElementById('resultsWrapper');
    if (!wrapper) return;

    const form = document.getElementById('filterForm');
    const savedTeacher = form ? form.querySelector('[name=teacher]').value : '';
    const savedSubject = form ? form.querySelector('[name=subject]').value : '';
    const savedDate    = form ? form.querySelector('[name=date]').value : '';

    // Remove any existing overlay first
    const existingOverlay = document.getElementById('loadingOverlay');
    if (existingOverlay) existingOverlay.remove();

    // ✅ Show loading overlay
    const overlay = document.createElement('div');
    overlay.id = 'loadingOverlay';
    overlay.style.cssText = `
        position:absolute; inset:0; background:rgba(255,255,255,0.75);
        display:flex; flex-direction:column; align-items:center; justify-content:center;
        z-index:10; border-radius:1rem; gap:10px;
    `;
    overlay.innerHTML = `
        <div style="width:36px;height:36px;border:3px solid #e2e8f0;border-top-color:#3b82f6;border-radius:50%;animation:spin 0.7s linear infinite;"></div>
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
    const newWrapper = tmp.querySelector('#resultsWrapper');
    if (newWrapper) {
        wrapper.innerHTML = newWrapper.innerHTML;
    }
    window.history.pushState({}, '', url);
    wrapper.style.pointerEvents = '';
    
    // ✅ Hide global spinner AFTER fetch completes
    if (typeof window.hideSpinner === 'function') {
        window.hideSpinner();
    }
        
        // ✅ REMOVE THE CUSTOM OVERLAY ON SUCCESS
        const loadingOverlay = document.getElementById('loadingOverlay');
        if (loadingOverlay) loadingOverlay.remove();

        const f = document.getElementById('filterForm');
        if (f) {
            f.querySelector('[name=teacher]').value = savedTeacher;
            f.querySelector('[name=subject]').value = savedSubject;
            f.querySelector('[name=date]').value    = savedDate;
        }

        wrapper.scrollIntoView({ behavior: 'smooth', block: 'start' });
    })
    .catch(() => {
    wrapper.style.pointerEvents = '';
    
    // ✅ Hide global spinner on error too
    if (typeof window.hideSpinner === 'function') {
        window.hideSpinner();
    }

    const loadingOverlay = document.getElementById('loadingOverlay');
    if (loadingOverlay) loadingOverlay.remove();
    window.location.href = url;
   });

}

document.addEventListener('click', function(e) {
    const link = e.target.closest('a');
    if (!link) return;
    if (!link.closest('#resultsWrapper')) return;
    if (!link.href || link.href === '#' || link.href === window.location.href) return;

    // ✅ Only intercept links that stay on the same base path (pagination)
    // Let "View Details" and other external links navigate normally
    const linkPath = new URL(link.href).pathname;
    const currentPath = window.location.pathname;
    if (linkPath !== currentPath) return; // ← ADD THIS LINE

    e.preventDefault();
    e.stopPropagation();
    loadPage(link.href);
});

window.addEventListener('popstate', () => location.reload());

document.getElementById('filterForm').addEventListener('submit', function(e) {
    e.preventDefault();
    const params = new URLSearchParams(new FormData(this)).toString();
    const base = window.location.pathname;
    loadPage(base + (params ? '?' + params : ''));
});

document.getElementById('clearFilter').addEventListener('click', function() {
    document.getElementById('filterForm').reset();
    loadPage(window.location.pathname);
});
</script>

<style>
@keyframes spin {
    0%  { transform: rotate(0deg); }
    100%{ transform: rotate(360deg); }
}
#resultsWrapper {
    position: relative;
    transition: opacity 0.2s ease;
}
</style>

@endsection