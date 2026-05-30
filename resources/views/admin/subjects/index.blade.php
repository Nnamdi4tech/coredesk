@extends('layouts.admin')

@section('content')

@php $subdomain = request()->route('subdomain'); @endphp

<div class="w-full px-6 py-6 mx-auto">

    {{-- PAGE HEADER --}}
    <div class="flex flex-wrap items-center justify-between mb-6 -mx-3">
        <div class="px-3">
            <h3 class="text-2xl font-bold text-slate-700 mb-1">Subjects</h3>
            <p class="text-sm text-slate-400">
                <i class="fa fa-home mr-1"></i> Dashboard
                <span class="mx-1 text-slate-300">/</span>
                <span class="text-slate-600">Subjects Management</span>
            </p>
        </div>
        <div class="px-3 flex gap-3 mt-3 md:mt-0">
            <a href="{{ route('tenant.subjects.create', $subdomain) }}"
               class="px-5 py-2 text-sm font-semibold text-white rounded-lg bg-gradient-to-tl from-gray-900 to-slate-700 shadow-soft-md hover:shadow-soft-xl transition-all hover:scale-105">
                <i class="fa fa-plus mr-1"></i> Add Subject
            </a>
        </div>
    </div>

    {{-- STAT CARDS ROW 1 — 4 CARDS --}}
    <div class="flex flex-wrap -mx-3 mb-6">
        
        <!-- card1 - Total Subjects -->
        <div class="w-full max-w-full px-3 mb-6 sm:w-1/2 sm:flex-none xl:mb-0 xl:w-1/4">
            <div class="relative flex flex-col min-w-0 break-words bg-white shadow-soft-xl rounded-2xl bg-clip-border">
                <div class="flex-auto p-4">
                    <div class="flex flex-row -mx-3">
                        <div class="flex-none w-2/3 max-w-full px-3">
                            <div>
                                <p class="mb-0 font-sans text-sm font-semibold leading-normal">Total Subjects</p>
                                <h5 class="mb-0 font-bold">
                                    {{ $totalSubjects }}
                                    <span class="text-sm leading-normal font-weight-bolder text-lime-500">+{{ $totalSubjects }}</span>
                                </h5>
                            </div>
                        </div>
                        <div class="px-3 text-right basis-1/3">
                            <div class="inline-block w-12 h-12 text-center rounded-lg bg-gradient-to-tl from-blue-500 to-cyan-400">
                                <i class="fa fa-book-open text-lg relative top-3.5 text-primary"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- card2 - Subjects with Teachers -->
        <div class="w-full max-w-full px-3 mb-6 sm:w-1/2 sm:flex-none xl:mb-0 xl:w-1/4">
            <div class="relative flex flex-col min-w-0 break-words bg-white shadow-soft-xl rounded-2xl bg-clip-border">
                <div class="flex-auto p-4">
                    <div class="flex flex-row -mx-3">
                        <div class="flex-none w-2/3 max-w-full px-3">
                            <div>
                                <p class="mb-0 font-sans text-sm font-semibold leading-normal">Subjects with Teachers</p>
                                <h5 class="mb-0 font-bold">
                                    {{ $subjectsWithTeachers }}
                                    <span class="text-sm leading-normal font-weight-bolder text-lime-500">{{ $assignedPercentage }}%</span>
                                </h5>
                            </div>
                        </div>
                        <div class="px-3 text-right basis-1/3">
                            <div class="inline-block w-12 h-12 text-center rounded-lg bg-gradient-to-tl from-green-500 to-emerald-400">
                                <i class="fa fa-chalkboard-user text-lg relative top-3.5 text-primary"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- card3 - Total Classes -->
        <div class="w-full max-w-full px-3 mb-6 sm:w-1/2 sm:flex-none xl:mb-0 xl:w-1/4">
            <div class="relative flex flex-col min-w-0 break-words bg-white shadow-soft-xl rounded-2xl bg-clip-border">
                <div class="flex-auto p-4">
                    <div class="flex flex-row -mx-3">
                        <div class="flex-none w-2/3 max-w-full px-3">
                            <div>
                                <p class="mb-0 font-sans text-sm font-semibold leading-normal">Total Classes</p>
                                <h5 class="mb-0 font-bold">
                                    {{ $totalClasses }}
                                    <span class="text-sm leading-normal font-weight-bolder text-purple-500">classes</span>
                                </h5>
                            </div>
                        </div>
                        <div class="px-3 text-right basis-1/3">
                            <div class="inline-block w-12 h-12 text-center rounded-lg bg-gradient-to-tl from-purple-600 to-pink-500">
                                <i class="fa fa-chalkboard text-lg relative top-3.5 text-info"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- card4 - Subjects without Teachers -->
        <div class="w-full max-w-full px-3 sm:w-1/2 sm:flex-none xl:w-1/4">
            <div class="relative flex flex-col min-w-0 break-words bg-white shadow-soft-xl rounded-2xl bg-clip-border">
                <div class="flex-auto p-4">
                    <div class="flex flex-row -mx-3">
                        <div class="flex-none w-2/3 max-w-full px-3">
                            <div>
                                <p class="mb-0 font-sans text-sm font-semibold leading-normal">Subjects without Teachers</p>
                                <h5 class="mb-0 font-bold">
                                    {{ $subjectsWithoutTeachers }}
                                    <span class="text-sm leading-normal font-weight-bolder text-red-500">{{ $unassignedPercentage }}%</span>
                                </h5>
                            </div>
                        </div>
                        <div class="px-3 text-right basis-1/3">
                            <div class="inline-block w-12 h-12 text-center rounded-lg bg-gradient-to-tl from-red-500 to-rose-400">
                                <i class="fa fa-user-slash text-lg relative top-3.5 text-primary"></i>
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

    {{-- SUBJECTS TABLE --}}
    <div id="subjectsWrapper" class="bg-white rounded-2xl shadow-soft-xl overflow-hidden">
        

        {{-- Table Header --}}
        <div class="flex flex-wrap items-center justify-between px-6 py-4 border-b border-gray-100 gap-3">
            <div>
                <h6 class="font-bold text-slate-700">All Subjects</h6>
                <p class="text-xs text-slate-400 mt-0.5"> Showing
                 {{ $subjects->total() }} {{ Str::plural('subject', $subjects->total()) }} total
               </p>
            </div>
            <div class="flex items-center gap-3">
                {{-- Search --}}
                <div class="relative">
                    <i class="fa fa-search absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-xs"></i>
                    <input type="text"
                           id="searchInput"
                           placeholder="Search subjects..."
                           class="pl-8 pr-4 py-2 text-sm border border-gray-200 rounded-lg focus:outline-none focus:border-fuchsia-300 w-52"
                           onkeyup="filterTable()" />
                </div>
            </div>
        </div>

        {{-- Table Body --}}
        <div class="overflow-x-auto">
            <table class="items-center w-full mb-0 align-top border-gray-200 text-slate-500" id="subjectsTable">
                <thead class="align-bottom bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xxs font-bold uppercase tracking-wider text-slate-400 opacity-70">#</th>
                        <th class="px-6 py-3 text-left text-xxs font-bold uppercase tracking-wider text-slate-400 opacity-70">Subject</th>
                        <th class="px-6 py-3 text-left text-xxs font-bold uppercase tracking-wider text-slate-400 opacity-70">Course Code</th>
                        <th class="px-6 py-3 text-left text-xxs font-bold uppercase tracking-wider text-slate-400 opacity-70">Teacher</th>
                        <th class="px-6 py-3 text-left text-xxs font-bold uppercase tracking-wider text-slate-400 opacity-70">Description</th>
                        <th class="px-6 py-3 text-center text-xxs font-bold uppercase tracking-wider text-slate-400 opacity-70">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($subjects as $subject)
                    <tr class="border-t border-gray-100 hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-3 align-middle">
                            <span class="text-xs text-slate-400">{{ $subjects->firstItem() + $loop->index }}</span>
                        </td>
                        <td class="px-6 py-3 align-middle">
                            <div class="flex items-center gap-3">
                                <div class="w-9 h-9 rounded-xl bg-gradient-to-tl from-blue-500 to-cyan-400 flex items-center justify-center text-info text-xs font-bold shadow-soft-md flex-shrink-0">
                                    {{ strtoupper(substr($subject->name, 0, 2)) }}
                                </div>
                                <p class="text-sm font-semibold text-slate-700 mb-0">{{ $subject->name }}</p>
                            </div>
                        </td>
                        <td class="px-6 py-3 align-middle">
                            @if($subject->course_code)
                                <span class="text-xs font-mono font-semibold bg-slate-100 text-slate-600 px-2 py-1 rounded-lg">
                                    {{ $subject->course_code }}
                                </span>
                            @else
                                <span class="text-xs text-slate-300">—</span>
                            @endif
                        </td>
                        <td class="px-6 py-3 align-middle">
                            @if($subject->teachers && $subject->teachers->count() > 0)
                                @php
                                    $firstTeacher = $subject->teachers->first();
                                @endphp
                                @if($firstTeacher && $firstTeacher->user)
                                    <div class="flex items-center gap-2">
                                        <div class="w-6 h-6 rounded-lg bg-gradient-to-tl from-purple-600 to-pink-500 flex items-center justify-center text-white text-xs font-bold flex-shrink-0">
                                            {{ strtoupper(substr($firstTeacher->user->name, 0, 1)) }}
                                        </div>
                                        <span class="text-sm text-slate-600">{{ $firstTeacher->user->name }}</span>
                                    </div>
                                @else
                                    <span class="text-xs text-slate-300 italic">Not assigned</span>
                                @endif
                            @else
                                <span class="text-xs text-slate-300 italic">Not assigned</span>
                            @endif
                        </td>
                        <td class="px-6 py-3 align-middle">
                            <p class="text-xs text-slate-500 max-w-xs truncate">
                                {{ $subject->description ?? '—' }}
                            </p>
                        </td>
                        <td class="px-6 py-3 align-middle text-center">
                            <div class="flex items-center justify-center gap-2">
    <a href="#"
       class="w-7 h-7 rounded-lg bg-blue-50 text-blue-500 flex items-center justify-center hover:bg-blue-100 transition-colors"
       title="View">
        <i class="fa fa-eye text-xs"></i>
    </a>
    <a href="{{ route('tenant.subjects.edit', [$subdomain, $subject->id]) }}"
       class="w-7 h-7 rounded-lg bg-amber-50 text-amber-500 flex items-center justify-center hover:bg-amber-100 transition-colors"
       title="Edit">
        <i class="fa fa-pen text-xs"></i>
    </a>
    <form method="POST" action="{{ route('tenant.subjects.destroy', [$subdomain, $subject->id]) }}"
          onsubmit="return confirm('Delete {{ $subject->name }}?')"
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
                        <td colspan="6" class="px-6 py-12 text-center">
                            <div class="flex flex-col items-center">
                                <div class="w-16 h-16 rounded-2xl bg-gray-100 flex items-center justify-center mb-4">
                                    <i class="fa fa-book text-gray-400 text-2xl"></i>
                                </div>
                                <p class="text-slate-500 font-semibold">No subjects found</p>
                                <p class="text-slate-400 text-sm mt-1">Add your first subject to get started</p>
                                <a href="{{ route('tenant.subjects.create', $subdomain) }}"
                                   class="mt-4 px-4 py-2 text-sm text-white rounded-lg bg-gradient-to-tl from-gray-900 to-slate-700">
                                    + Add Subject
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
        <span class="font-semibold text-slate-600">{{ $subjects->firstItem() }}–{{ $subjects->lastItem() }}</span>
        of
        <span class="font-semibold text-slate-600">{{ $subjects->total() }}</span>
        {{ Str::plural('subject', $subjects->total()) }}
    </p>
    <div>{{ $subjects->links() }}</div>
</div>

    </div>

</div>

{{-- Live search script --}}
<script>
function loadSubjectsPage(url) {
    const wrapper = document.getElementById('subjectsWrapper');
    if (!wrapper) return;

    const overlay = document.createElement('div');
    overlay.style.cssText = `
        position:absolute; inset:0; background:rgba(255,255,255,0.75);
        display:flex; flex-direction:column; align-items:center; justify-content:center;
        z-index:10; border-radius:1rem; gap:10px;
    `;
    overlay.innerHTML = `
        <div style="width:36px;height:36px;border:3px solid #e2e8f0;border-top-color:#3b82f6;border-radius:50%;animation:subjectSpin 0.7s linear infinite;"></div>
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
        const newWrapper = tmp.querySelector('#subjectsWrapper');
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

document.addEventListener('click', function(e) {
    const link = e.target.closest('a');
    if (!link) return;
    if (!link.closest('#subjectsWrapper')) return;
    if (!link.href || link.href === '#' || link.href === window.location.href) return;
    
    // ✅ Only intercept pagination links
    const url = new URL(link.href);
    if (url.searchParams.has('page')) {
        e.preventDefault();
        e.stopPropagation();
        loadSubjectsPage(link.href);
    }
    // ✅ Everything else (Add Subject, Edit, etc.) works normally
});

function filterTable() {
    const input = document.getElementById('searchInput').value.toLowerCase();
    const rows = document.querySelectorAll('#subjectsTable tbody tr');
    rows.forEach(row => {
        row.style.display = row.innerText.toLowerCase().includes(input) ? '' : 'none';
    });
}

window.addEventListener('popstate', () => location.reload());
</script>

<style>
@keyframes subjectSpin {
    0%   { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}
#subjectsWrapper { position: relative; }
</style>

@endsection