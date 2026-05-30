{{-- resources/views/teacher/lecture_note/view.blade.php --}}
@extends('layouts.admin')

@section('content')

@php $subdomain = request()->route('subdomain'); @endphp

<div class="w-full px-6 py-6 mx-auto">
    <div class="flex items-center justify-between mb-6">
        <div>
            <h3 class="text-2xl font-bold text-slate-700 mb-1">{{ $lectureNote->title }}</h3>
            <p class="text-sm text-slate-400">Viewing lecture note</p>
        </div>
        <div class="flex gap-2">
            {{-- ✅ PRINT BUTTON - Only show for text content --}}
            @if($lectureNote->type === 'text')
                <button onclick="printLectureNote()"
                        class="px-4 py-2 text-sm font-semibold text-white rounded-lg bg-gradient-to-tl from-blue-600 to-cyan-500 shadow-soft-md hover:shadow-soft-xl hover:scale-105 transition-all">
                    <i class="fa fa-print mr-1"></i> Print
                </button>
            @endif
            <a href="{{ route('teacher.lecture_note.index', $subdomain) }}" 
               class="px-4 py-2 text-sm border border-gray-300 rounded-lg text-slate-600 hover:bg-gray-50 transition-all">
                <i class="fa fa-arrow-left mr-1"></i> Back
            </a>
        </div>
    </div>

    <div class="bg-white shadow-soft-xl rounded-2xl overflow-hidden" id="printArea">
        <div class="px-6 py-4 border-b border-gray-100 bg-gradient-to-r from-purple-50 to-pink-50">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-lg bg-gradient-to-tl from-purple-500 to-pink-400 flex items-center justify-center">
                    <i class="fa fa-book-open text-black text-sm"></i>
                </div>
                <div>
                    <h6 class="font-bold text-slate-700 mb-0">{{ $lectureNote->title }}</h6>
                    <p class="text-xs text-slate-400">Submitted {{ $lectureNote->created_at->format('M d, Y') }}</p>
                </div>
            </div>
        </div>

        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div><p class="text-xs text-slate-400">Class</p><p class="text-sm font-semibold">{{ $lectureNote->class->name ?? 'N/A' }}</p></div>
                <div><p class="text-xs text-slate-400">Subject</p><p class="text-sm font-semibold">{{ $lectureNote->subject->name ?? 'N/A' }}</p></div>
                <div><p class="text-xs text-slate-400">Status</p>
                    @if($lectureNote->approved)
                        <span class="text-xs font-semibold bg-green-50 text-green-600 px-2 py-1 rounded-full"><i class="fa fa-check-circle mr-1"></i> Approved</span>
                    @elseif($lectureNote->rejected)
                        <span class="text-xs font-semibold bg-red-50 text-red-600 px-2 py-1 rounded-full"><i class="fa fa-times-circle mr-1"></i> Rejected</span>
                    @else
                        <span class="text-xs font-semibold bg-orange-50 text-orange-600 px-2 py-1 rounded-full"><i class="fa fa-clock mr-1"></i> Pending Approval</span>
                    @endif
                </div>
            </div>

            @if($lectureNote->type === 'text')
                <div class="border-t border-gray-100 pt-6">
                    <p class="text-xs text-slate-400 mb-2">Content</p>
                    <div class="bg-gray-50 rounded-xl p-4 text-slate-700 leading-relaxed lecture-content">{!! nl2br(e($lectureNote->content)) !!}</div>
                </div>
            @elseif($lectureNote->file_path)
                <div class="border-t border-gray-100 pt-6">
                    <div class="bg-gray-50 rounded-xl p-6 text-center">
                        <i class="fa fa-file-pdf text-red-500 text-5xl mb-3"></i>
                        <p class="text-sm font-semibold text-slate-700">{{ $lectureNote->file_name }}</p>
                        <a href="{{ Storage::url($lectureNote->file_path) }}" target="_blank" class="inline-flex items-center gap-2 mt-3 px-4 py-2 text-sm font-semibold text-white bg-red-600 rounded-lg hover:bg-red-700">
                            <i class="fa fa-download"></i> Download File
                        </a>
                    </div>
                </div>
            @endif

            @if($lectureNote->rejection_reason)
            <div class="mt-4 p-4 bg-red-50 border border-red-200 rounded-xl">
                <p class="text-xs font-semibold text-red-600 mb-1">Rejection Reason</p>
                <p class="text-sm text-red-700">{{ $lectureNote->rejection_reason }}</p>
            </div>
            @endif
        </div>
    </div>
</div>

{{-- Print Styles --}}
<style>
@media print {
    body * {
        visibility: hidden;
    }
    #printArea, #printArea * {
        visibility: visible;
    }
    #printArea {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        margin: 0;
        padding: 20px;
        background: white;
    }
    .no-print {
        display: none !important;
    }
    .bg-gradient-to-r, .bg-gradient-to-tl {
        background: white !important;
    }
    .shadow-soft-xl, .shadow-soft-md {
        box-shadow: none !important;
    }
    .border, .border-b {
        border: 1px solid #e2e8f0 !important;
    }
    .lecture-content {
        page-break-inside: avoid;
        white-space: pre-wrap;
        word-wrap: break-word;
    }
    .text-xs {
        font-size: 10px !important;
    }
    .text-sm {
        font-size: 12px !important;
    }
    .text-lg {
        font-size: 14px !important;
    }
}
</style>

<script>
function printLectureNote() {
    // Store original title
    const originalTitle = document.title;
    // Set print title
    document.title = "{{ $lectureNote->title }} - Lecture Note";
    // Trigger print
    window.print();
    // Restore original title
    document.title = originalTitle;
}
</script>

@endsection