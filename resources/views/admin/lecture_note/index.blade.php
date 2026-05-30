{{-- resources/views/admin/lecture_note/index.blade.php --}}
@extends('layouts.admin')

@section('content')

@php $subdomain = request()->route('subdomain'); @endphp

<div class="w-full px-6 py-6 mx-auto">

    {{-- PAGE HEADER --}}
    <div class="flex flex-wrap items-center justify-between mb-6 -mx-3">
        <div class="px-3">
            <h3 class="text-2xl font-bold text-slate-700 mb-1">Lecture Notes Review</h3>
            <p class="text-sm text-slate-400">
                <i class="fa fa-home mr-1"></i> Dashboard
                <span class="mx-1 text-slate-300">/</span>
                <span class="text-slate-600">Lecture Notes Review</span>
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

    {{-- STAT CARDS --}}
    <div class="flex flex-wrap -mx-3 mb-6">
        <div class="w-full max-w-full px-3 mb-6 sm:w-1/2 sm:flex-none xl:mb-0 xl:w-1/4">
            <div class="relative flex flex-col min-w-0 break-words bg-white shadow-soft-xl rounded-2xl bg-clip-border">
                <div class="flex-auto p-4">
                    <div class="flex flex-row -mx-3">
                        <div class="flex-none w-2/3 max-w-full px-3">
                            <div>
                                <p class="mb-0 font-sans text-sm font-semibold leading-normal">Total Notes</p>
                                <h5 class="mb-0 font-bold">{{ $totalNotes }}</h5>
                            </div>
                        </div>
                        <div class="px-3 text-right basis-1/3">
                            <div class="inline-block w-12 h-12 text-center rounded-lg bg-gradient-to-tl from-purple-500 to-pink-400">
                                <i class="fa fa-book-open text-lg relative top-3.5 text-black"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="w-full max-w-full px-3 mb-6 sm:w-1/2 sm:flex-none xl:mb-0 xl:w-1/4">
            <div class="relative flex flex-col min-w-0 break-words bg-white shadow-soft-xl rounded-2xl bg-clip-border">
                <div class="flex-auto p-4">
                    <div class="flex flex-row -mx-3">
                        <div class="flex-none w-2/3 max-w-full px-3">
                            <div>
                                <p class="mb-0 font-sans text-sm font-semibold leading-normal">Pending</p>
                                <h5 class="mb-0 font-bold text-orange-600">{{ $pendingNotes }}</h5>
                            </div>
                        </div>
                        <div class="px-3 text-right basis-1/3">
                            <div class="inline-block w-12 h-12 text-center rounded-lg bg-gradient-to-tl from-orange-500 to-yellow-400">
                                <i class="fa fa-clock text-lg relative top-3.5 text-black"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="w-full max-w-full px-3 mb-6 sm:w-1/2 sm:flex-none xl:mb-0 xl:w-1/4">
            <div class="relative flex flex-col min-w-0 break-words bg-white shadow-soft-xl rounded-2xl bg-clip-border">
                <div class="flex-auto p-4">
                    <div class="flex flex-row -mx-3">
                        <div class="flex-none w-2/3 max-w-full px-3">
                            <div>
                                <p class="mb-0 font-sans text-sm font-semibold leading-normal">Approved</p>
                                <h5 class="mb-0 font-bold text-green-600">{{ $approvedNotes }}</h5>
                            </div>
                        </div>
                        <div class="px-3 text-right basis-1/3">
                            <div class="inline-block w-12 h-12 text-center rounded-lg bg-gradient-to-tl from-green-500 to-emerald-400">
                                <i class="fa fa-check-circle text-lg relative top-3.5 text-black"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="w-full max-w-full px-3 sm:w-1/2 sm:flex-none xl:w-1/4">
            <div class="relative flex flex-col min-w-0 break-words bg-white shadow-soft-xl rounded-2xl bg-clip-border">
                <div class="flex-auto p-4">
                    <div class="flex flex-row -mx-3">
                        <div class="flex-none w-2/3 max-w-full px-3">
                            <div>
                                <p class="mb-0 font-sans text-sm font-semibold leading-normal">Rejected</p>
                                <h5 class="mb-0 font-bold text-red-600">{{ $rejectedNotes }}</h5>
                            </div>
                        </div>
                        <div class="px-3 text-right basis-1/3">
                            <div class="inline-block w-12 h-12 text-center rounded-lg bg-gradient-to-tl from-red-500 to-rose-400">
                                <i class="fa fa-times-circle text-lg relative top-3.5 text-black"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- FILTER BAR --}}
    <div class="bg-white shadow-soft-xl rounded-2xl px-6 py-4 mb-5">
        <form id="filterForm" class="flex flex-wrap items-end gap-3">
            <div class="flex flex-col gap-1 flex-1 min-w-[160px]">
                <label class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Class</label>
                <select name="class_id" class="text-sm border border-gray-200 rounded-lg px-3 py-2">
                    <option value="">All Classes</option>
                    @foreach($classes as $class)
                        <option value="{{ $class->id }}">{{ $class->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="flex flex-col gap-1 flex-1 min-w-[160px]">
                <label class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Subject</label>
                <select name="subject_id" class="text-sm border border-gray-200 rounded-lg px-3 py-2">
                    <option value="">All Subjects</option>
                    @foreach($subjects as $subject)
                        <option value="{{ $subject->id }}">{{ $subject->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="flex flex-col gap-1 flex-1 min-w-[160px]">
                <label class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Status</label>
                <select name="status" class="text-sm border border-gray-200 rounded-lg px-3 py-2">
                    <option value="">All Status</option>
                    <option value="pending">Pending</option>
                    <option value="approved">Approved</option>
                    <option value="rejected">Rejected</option>
                </select>
            </div>
            <div class="flex gap-2">
                <button type="submit" class="inline-flex items-center gap-1.5 px-4 py-2 text-xs font-semibold text-white rounded-lg bg-gradient-to-tl from-blue-600 to-cyan-500 shadow-soft-sm hover:scale-105 transition-all">
                    <i class="fa fa-search text-xs"></i> Filter
                </button>
                <button type="button" id="clearFilter" class="inline-flex items-center gap-1.5 px-4 py-2 text-xs font-semibold text-slate-600 rounded-lg border border-gray-200 hover:bg-gray-50 transition-all">
                    <i class="fa fa-times text-xs"></i> Clear
                </button>
            </div>
        </form>
    </div>

    {{-- LECTURE NOTES TABLE --}}
<form id="bulkApproveForm" action="{{ route('tenant.admin.lecture_note.bulk_approve', $subdomain) }}" method="POST">
@csrf
<div class="bg-white shadow-soft-xl rounded-2xl overflow-hidden">
    <div class="flex flex-wrap items-center justify-between px-6 py-4 border-b border-gray-100 gap-3">
        <div>
            <h6 class="font-bold text-slate-700">Submitted Lecture Notes</h6>
            <p class="text-xs text-slate-400 mt-0.5">{{ $lectureNotes->total() }} note(s) total</p>
        </div>
        <div class="flex gap-2">
            <button type="submit" id="bulkApproveBtn" class="px-4 py-2 text-xs font-semibold text-white rounded-lg bg-gradient-to-tl from-green-600 to-emerald-500 shadow-soft-sm hover:scale-105 transition-all">
                <i class="fa fa-check-circle mr-1"></i> Bulk Approve
            </button>
        </div>
    </div>

        @if($lectureNotes->count() > 0)
        <div class="overflow-x-auto">
            <table class="items-center w-full mb-0 align-top border-gray-200 text-slate-500">
                <thead class="align-bottom bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left w-8"><input type="checkbox" id="selectAll"></th>
                        <th class="px-6 py-3 text-left text-xxs font-bold uppercase tracking-wider">Class</th>
                        <th class="px-6 py-3 text-left text-xxs font-bold uppercase tracking-wider">Subject</th>
                        <th class="px-6 py-3 text-left text-xxs font-bold uppercase tracking-wider">Teacher</th>
                        <th class="px-6 py-3 text-left text-xxs font-bold uppercase tracking-wider">Title</th>
                        <th class="px-6 py-3 text-left text-xxs font-bold uppercase tracking-wider">Type</th>
                        <th class="px-6 py-3 text-left text-xxs font-bold uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-center text-xxs font-bold uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($lectureNotes as $note)
                    <tr class="border-t border-gray-100 hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4"><input type="checkbox" class="noteCheckbox" name="ids[]" value="{{ $note->id }}"></td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-2">
                                <div class="w-6 h-6 rounded-lg bg-gradient-to-tl from-blue-500 to-cyan-400 flex items-center justify-center">
                                    <i class="fa fa-chalkboard text-white text-xs"></i>
                                </div>
                                <span class="text-sm font-semibold text-slate-700">{{ $note->class->name ?? 'N/A' }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-2">
                                <div class="w-6 h-6 rounded-lg bg-gradient-to-tl from-purple-500 to-pink-400 flex items-center justify-center">
                                    <i class="fa fa-book text-white text-xs"></i>
                                </div>
                                <span class="text-sm text-slate-600">{{ $note->subject->name ?? 'N/A' }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-2">
                                <div class="w-6 h-6 rounded-full bg-gradient-to-tl from-green-500 to-emerald-400 flex items-center justify-center">
                                    <span class="text-white text-xs font-bold">{{ strtoupper(substr($note->teacher->name ?? 'N/A', 0, 1)) }}</span>
                                </div>
                                <span class="text-sm text-slate-600">{{ $note->teacher->name ?? 'N/A' }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="text-sm font-semibold text-slate-700">{{ Str::limit($note->title, 40) }}</span>
                        </td>
                        <td class="px-6 py-4">
                            @if($note->type === 'text')
                                <span class="text-xs px-2 py-1 rounded-full bg-blue-50 text-blue-600">
                                    <i class="fa fa-pencil-alt mr-1"></i> Text
                                </span>
                            @else
                                <span class="text-xs px-2 py-1 rounded-full bg-purple-50 text-purple-600">
                                    <i class="fa fa-file-pdf mr-1"></i> File
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            @if($note->approved)
                                <span class="inline-flex items-center gap-1 text-xs font-semibold bg-green-50 text-green-600 px-2.5 py-1 rounded-full">
                                    <i class="fa fa-check-circle text-xs"></i> Approved
                                </span>
                            @elseif($note->rejected)
                                <span class="inline-flex items-center gap-1 text-xs font-semibold bg-red-50 text-red-600 px-2.5 py-1 rounded-full">
                                    <i class="fa fa-times-circle text-xs"></i> Rejected
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1 text-xs font-semibold bg-orange-50 text-orange-600 px-2.5 py-1 rounded-full">
                                    <i class="fa fa-clock text-xs"></i> Pending
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 align-middle text-center">
                            <div class="flex items-center justify-center gap-2">
                                <a href="{{ route('tenant.admin.lecture_note.show', [$subdomain, $note->id]) }}"
                                   class="w-7 h-7 rounded-lg bg-blue-50 text-blue-500 flex items-center justify-center hover:bg-blue-100 transition-colors">
                                    <i class="fa fa-eye text-xs"></i>
                                </a>
                                @if(!$note->approved)
                                <form action="{{ route('tenant.admin.lecture_note.approve', [$subdomain, $note->id]) }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit" onclick="return confirm('Approve this lecture note?')"
                                            class="w-7 h-7 rounded-lg bg-green-50 text-green-500 flex items-center justify-center hover:bg-green-100 transition-colors">
                                        <i class="fa fa-check text-xs"></i>
                                    </button>
                                </form>
                                @endif
                                <form action="{{ route('tenant.admin.lecture_note.destroy', [$subdomain, $note->id]) }}" method="POST" class="inline"
                                      onsubmit="return confirm('Delete this lecture note?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="w-7 h-7 rounded-lg bg-red-50 text-red-500 flex items-center justify-center hover:bg-red-100 transition-colors">
                                        <i class="fa fa-trash text-xs"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="px-6 py-4 border-t border-gray-100">
            {{ $lectureNotes->links() }}
        </div>
        @else
        <div class="p-12 text-center">
            <div class="w-20 h-20 rounded-2xl bg-gray-100 flex items-center justify-center mb-4 mx-auto">
                <i class="fa fa-book-open text-gray-400 text-3xl"></i>
            </div>
            <p class="text-slate-500 font-semibold text-lg">No lecture notes submitted</p>
            <p class="text-slate-400 text-sm mt-1">When teachers submit lecture notes, they will appear here for approval.</p>
        </div>
        @endif
    </div>
    </form>

    {{-- Info Card --}}
    <div class="mt-5 p-4 bg-gradient-to-r from-blue-50 to-cyan-50 rounded-xl border border-blue-100">
        <div class="flex items-start gap-3">
            <div class="w-8 h-8 rounded-lg bg-gradient-to-tl from-blue-500 to-cyan-400 flex items-center justify-center flex-shrink-0">
                <i class="fa fa-info-circle text-black text-xs"></i>
            </div>
            <div>
                <p class="text-sm font-semibold text-blue-800">Review Process</p>
                <p class="text-xs text-blue-600 mt-0.5">
                    Click <strong>View</strong> to read the full lecture note. You can approve or reject each submission. Once approved, teachers cannot edit or delete the note unless you reject it first.
                </p>
            </div>
        </div>
    </div>
</div>

<script>
document.getElementById('selectAll')?.addEventListener('change', function(e) {
    document.querySelectorAll('.noteCheckbox').forEach(cb => cb.checked = e.target.checked);
});

document.getElementById('bulkApproveBtn')?.addEventListener('click', function(e) {
    const checked = document.querySelectorAll('.noteCheckbox:checked');
    if (checked.length === 0) {
        e.preventDefault();
        alert('Please select at least one lecture note to approve.');
    } else if (!confirm(`Approve ${checked.length} selected lecture note(s)?`)) {
        e.preventDefault();
    }
});

document.getElementById('clearFilter')?.addEventListener('click', function() {
    document.querySelectorAll('#filterForm select').forEach(select => select.value = '');
    document.getElementById('filterForm').submit();
});
</script>

@endsection