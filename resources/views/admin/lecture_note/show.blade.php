{{-- resources/views/admin/lecture_note/show.blade.php --}}
@extends('layouts.admin')

@section('content')

@php $subdomain = request()->route('subdomain'); @endphp

<div class="w-full px-6 py-6 mx-auto">
    <div class="flex items-center justify-between mb-6">
        <div>
            <h3 class="text-2xl font-bold text-slate-700 mb-1">Lecture Note Details</h3>
            <p class="text-sm text-slate-400">
                <i class="fa fa-home mr-1"></i> Dashboard
                <span class="mx-1 text-slate-300">/</span>
                <a href="{{ route('tenant.admin.lecture_note.index', $subdomain) }}" class="hover:text-slate-600">Lecture Notes</a>
                <span class="mx-1 text-slate-300">/</span>
                <span class="text-slate-600">View</span>
            </p>
        </div>
        <a href="{{ route('tenant.admin.lecture_note.index', $subdomain) }}" class="px-4 py-2 text-sm border border-gray-300 rounded-lg text-slate-600 hover:bg-gray-50 transition-all">
            <i class="fa fa-arrow-left mr-1"></i> Back
        </a>
    </div>

    <div class="bg-white shadow-soft-xl rounded-2xl overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100 bg-gradient-to-r from-purple-50 to-pink-50">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-lg bg-gradient-to-tl from-purple-500 to-pink-400 flex items-center justify-center">
                    <i class="fa fa-book-open text-black text-sm"></i>
                </div>
                <div>
                    <h6 class="font-bold text-slate-700 mb-0">{{ $lectureNote->title }}</h6>
                    <p class="text-xs text-slate-400">Submitted {{ $lectureNote->created_at->diffForHumans() }}</p>
                </div>
            </div>
        </div>

        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div>
                    <p class="text-xs text-slate-400">Class</p>
                    <p class="text-sm font-semibold text-slate-700">{{ $lectureNote->class->name ?? 'N/A' }}</p>
                </div>
                <div>
                    <p class="text-xs text-slate-400">Subject</p>
                    <p class="text-sm font-semibold text-slate-700">{{ $lectureNote->subject->name ?? 'N/A' }}</p>
                </div>
                <div>
                    <p class="text-xs text-slate-400">Teacher</p>
                    <p class="text-sm font-semibold text-slate-700">{{ $lectureNote->teacher->name ?? 'N/A' }}</p>
                </div>
                <div>
                    <p class="text-xs text-slate-400">Type</p>
                    <p class="text-sm font-semibold">
                        @if($lectureNote->type === 'text')
                            <span class="text-blue-600"><i class="fa fa-pencil-alt mr-1"></i> Text Note</span>
                        @else
                            <span class="text-purple-600"><i class="fa fa-file-pdf mr-1"></i> File Upload</span>
                        @endif
                    </p>
                </div>
            </div>

            <div class="border-t border-gray-100 pt-6">
                @if($lectureNote->type === 'text')
                    <p class="text-xs text-slate-400 mb-2">Content</p>
                    <div class="bg-gray-50 rounded-xl p-4 text-slate-700 leading-relaxed">
                        {!! nl2br(e($lectureNote->content)) !!}
                    </div>
                @elseif($lectureNote->file_path)
                    <div class="bg-gray-50 rounded-xl p-6 text-center">
                        <i class="fa fa-file-pdf text-red-500 text-5xl mb-3"></i>
                        <p class="text-sm font-semibold text-slate-700">{{ $lectureNote->file_name }}</p>
                        <a href="{{ Storage::url($lectureNote->file_path) }}" target="_blank" class="inline-flex items-center gap-2 mt-3 px-4 py-2 text-sm font-semibold text-white bg-red-600 rounded-lg hover:bg-red-700">
                            <i class="fa fa-download"></i> Download File
                        </a>
                    </div>
                @endif

                @if($lectureNote->rejection_reason)
                <div class="mt-4 p-4 bg-red-50 border border-red-200 rounded-xl">
                    <p class="text-xs font-semibold text-red-600 mb-1">Rejection Reason</p>
                    <p class="text-sm text-red-700">{{ $lectureNote->rejection_reason }}</p>
                </div>
                @endif
            </div>

            <div class="flex items-center justify-end gap-3 mt-6 pt-4 border-t border-gray-100">
                @if(!$lectureNote->approved && !$lectureNote->rejected)
                <form action="{{ route('tenant.admin.lecture_note.reject', [$subdomain, $lectureNote->id]) }}" method="POST" id="rejectForm" class="inline">
                    @csrf
                    <button type="button" onclick="showRejectModal()" class="px-6 py-2.5 text-sm font-semibold text-white rounded-lg bg-gradient-to-tl from-red-600 to-rose-500 shadow-soft-md hover:shadow-soft-xl hover:scale-105 transition-all">
                        <i class="fa fa-times-circle mr-1"></i> Reject
                    </button>
                </form>
                <form action="{{ route('tenant.admin.lecture_note.approve', [$subdomain, $lectureNote->id]) }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" onclick="return confirm('Approve this lecture note?')" class="px-6 py-2.5 text-sm font-semibold text-white rounded-lg bg-gradient-to-tl from-green-600 to-emerald-500 shadow-soft-md hover:shadow-soft-xl hover:scale-105 transition-all">
                        <i class="fa fa-check-circle mr-1"></i> Approve
                    </button>
                </form>
                @elseif($lectureNote->approved)
                    <span class="px-6 py-2.5 text-sm font-semibold text-green-600 bg-green-50 rounded-lg">
                        <i class="fa fa-check-circle mr-1"></i> Approved
                    </span>
                @elseif($lectureNote->rejected)
                    <span class="px-6 py-2.5 text-sm font-semibold text-red-600 bg-red-50 rounded-lg">
                        <i class="fa fa-times-circle mr-1"></i> Rejected
                    </span>
                @endif
            </div>
        </div>
    </div>
</div>

<div id="rejectModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
    <div class="bg-white rounded-2xl w-full max-w-md mx-4 p-6">
        <h5 class="text-lg font-bold text-slate-700 mb-4">Reject Lecture Note</h5>
        <textarea id="rejectionReason" rows="3" placeholder="Please provide a reason for rejection..." class="w-full text-sm rounded-lg border border-gray-200 p-3 focus:outline-none focus:border-red-300"></textarea>
        <div class="flex justify-end gap-3 mt-4">
            <button onclick="closeRejectModal()" class="px-4 py-2 text-sm font-semibold text-slate-600 border border-gray-300 rounded-lg">Cancel</button>
            <button onclick="submitReject()" class="px-4 py-2 text-sm font-semibold text-white bg-red-600 rounded-lg">Reject</button>
        </div>
    </div>
</div>

<script>
function showRejectModal() {
    document.getElementById('rejectModal').classList.remove('hidden');
    document.getElementById('rejectModal').classList.add('flex');
}
function closeRejectModal() {
    document.getElementById('rejectModal').classList.add('hidden');
    document.getElementById('rejectModal').classList.remove('flex');
}
function submitReject() {
    const reason = document.getElementById('rejectionReason').value;
    if (!reason.trim()) {
        alert('Please provide a reason for rejection.');
        return;
    }
    const form = document.getElementById('rejectForm');
    const input = document.createElement('input');
    input.type = 'hidden';
    input.name = 'rejection_reason';
    input.value = reason;
    form.appendChild(input);
    form.submit();
}
</script>

@endsection