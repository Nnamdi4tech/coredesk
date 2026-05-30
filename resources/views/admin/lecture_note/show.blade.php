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
        <div class="flex gap-2">
            @if($lectureNote->type === 'text' && !empty(trim($lectureNote->content ?? '')))
                <button onclick="printLectureNote()"
                        class="px-4 py-2 text-sm font-semibold text-white rounded-lg bg-gradient-to-tl from-blue-600 to-cyan-500 shadow-soft-md hover:shadow-soft-xl hover:scale-105 transition-all">
                    <i class="fa fa-print mr-1"></i> Print
                </button>
            @endif
            <a href="{{ route('tenant.admin.lecture_note.index', $subdomain) }}" class="px-4 py-2 text-sm border border-gray-300 rounded-lg text-slate-600 hover:bg-gray-50 transition-all">
                <i class="fa fa-arrow-left mr-1"></i> Back
            </a>
        </div>
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
                    <div class="bg-gray-50 rounded-xl p-4 text-slate-700 leading-relaxed lecture-content">
                        {!! nl2br(e($lectureNote->content)) !!}
                    </div>
                @elseif($lectureNote->file_path)
                    <div class="bg-gray-50 rounded-xl p-6 text-center">
                        <i class="fa fa-file-pdf text-red-500 text-5xl mb-3"></i>
                        <p class="text-sm font-semibold text-slate-700">{{ $lectureNote->file_name }}</p>
                        <a href="{{ Storage::url($lectureNote->file_path) }}" target="_blank" class="inline-flex items-center gap-2 mt-3 px-4 py-2 text-sm font-semibold text-black bg-red-600 rounded-lg hover:bg-red-700">
                            <i class="fa fa-download text-black"></i> Download File
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

{{-- Reject Modal --}}
<div id="rejectModal" class="fixed inset-0 bg-black bg-opacity-50 z-[9999]" style="display: none;">
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="bg-white rounded-2xl w-full max-w-md p-6 shadow-xl relative">
            <div class="flex items-center justify-between mb-4">
                <h5 class="text-lg font-bold text-slate-700">Reject Lecture Note</h5>
                <button onclick="closeRejectModal()" class="text-gray-400 hover:text-gray-600">
                    <i class="fa fa-times"></i>
                </button>
            </div>
            <p class="text-sm text-slate-600 mb-3">Please provide a reason for rejecting this lecture note:</p>
            <textarea id="rejectionReason" rows="4" 
                      placeholder="e.g., Contains errors, incomplete content, off-topic, etc." 
                      class="w-full text-sm rounded-lg border border-gray-300 p-3 focus:outline-none focus:border-red-400 focus:ring-1 focus:ring-red-200"></textarea>
            <div class="flex justify-end gap-3 mt-5">
                <button onclick="closeRejectModal()" class="px-4 py-2 text-sm font-semibold text-slate-600 border border-gray-300 rounded-lg hover:bg-gray-50 transition">
                    Cancel
                </button>
                <button onclick="submitReject()" class="px-4 py-2 text-sm font-semibold text-white bg-gradient-to-tl from-red-600 to-rose-500 rounded-lg hover:shadow-md transition">
                    <i class="fa fa-check-circle mr-1"></i> Confirm Rejection
                </button>
            </div>
        </div>
    </div>
</div>

<script>
function showRejectModal() {
    const modal = document.getElementById('rejectModal');
    modal.style.display = 'block';
    document.getElementById('rejectionReason').value = '';
    // Auto focus on textarea
    setTimeout(() => {
        document.getElementById('rejectionReason').focus();
    }, 100);
}

function closeRejectModal() {
    const modal = document.getElementById('rejectModal');
    modal.style.display = 'none';
}

function submitReject() {
    const reason = document.getElementById('rejectionReason').value.trim();
    if (!reason) {
        alert('Please provide a reason for rejection.');
        return;
    }
    
    const form = document.getElementById('rejectForm');
    
    // Remove any existing rejection reason input
    const oldInput = form.querySelector('input[name="rejection_reason"]');
    if (oldInput) oldInput.remove();
    
    // Add new hidden input with reason
    const input = document.createElement('input');
    input.type = 'hidden';
    input.name = 'rejection_reason';
    input.value = reason;
    form.appendChild(input);
    
    // Submit the form
    form.submit();
}

// Close modal when clicking outside
document.addEventListener('click', function(e) {
    const modal = document.getElementById('rejectModal');
    if (modal && modal.style.display === 'block') {
        if (e.target === modal) {
            closeRejectModal();
        }
    }
});

function printLectureNote() {
    const content = document.querySelector('.lecture-content').innerHTML;
    const title = @json($lectureNote->title);
    const className = @json($lectureNote->class->name ?? 'N/A');
    const subject = @json($lectureNote->subject->name ?? 'N/A');
    const teacher = @json($lectureNote->teacher->name ?? 'N/A');
    const date = @json($lectureNote->created_at->format('M d, Y'));

    const printWindow = window.open('', '_blank');
    printWindow.document.write(`
        <!DOCTYPE html>
        <html>
        <head>
            <title>${title} - Lecture Note</title>
            <style>
                body { font-family: Arial, sans-serif; margin: 40px; color: #000; font-size: 12pt; line-height: 1.6; }
                h1 { font-size: 18pt; margin-bottom: 5px; }
                .meta { font-size: 10pt; color: #444; margin-bottom: 20px; border-bottom: 1px solid #ccc; padding-bottom: 10px; }
                .meta span { margin-right: 20px; }
                .content { margin-top: 20px; white-space: pre-wrap; word-wrap: break-word; }
            </style>
        </head>
        <body>
            <h1>${title}</h1>
            <div class="meta">
                <span><strong>Class:</strong> ${className}</span>
                <span><strong>Subject:</strong> ${subject}</span>
                <span><strong>Teacher:</strong> ${teacher}</span>
                <span><strong>Date:</strong> ${date}</span>
            </div>
            <div class="content">${content}</div>
        </body>
        </html>
    `);
    printWindow.document.close();
    printWindow.focus();
    printWindow.print();
    printWindow.close();
}
</script>

@endsection