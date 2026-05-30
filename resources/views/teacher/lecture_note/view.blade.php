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
            @if($lectureNote->type === 'text' && !empty(trim($lectureNote->content)))
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
                <div>
                    <p class="text-xs text-slate-400">Class</p>
                    <p class="text-sm font-semibold">{{ $lectureNote->class->name ?? 'N/A' }}</p>
                </div>
                <div>
                    <p class="text-xs text-slate-400">Subject</p>
                    <p class="text-sm font-semibold">{{ $lectureNote->subject->name ?? 'N/A' }}</p>
                </div>
                <div>
                    <p class="text-xs text-slate-400">Status</p>
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
                    <div class="flex items-center justify-between mb-3">
                        <p class="text-xs font-semibold text-slate-600">
                            <i class="fa fa-file-alt mr-1"></i> Content
                        </p>
                        @if(!empty(trim($lectureNote->content)))
                            <p class="text-xs text-slate-400">
                                <i class="fa fa-file-text-o mr-1"></i> 
                                {{ str_word_count(strip_tags($lectureNote->content)) }} words
                            </p>
                        @endif
                    </div>
                    
                    @if(empty(trim($lectureNote->content)))
                        <div class="bg-yellow-50 border border-yellow-200 rounded-xl p-6 text-yellow-700 text-center">
                            <i class="fa fa-exclamation-triangle text-2xl mb-2 block"></i>
                            <p class="font-semibold">No content has been added to this lecture note yet.</p>
                            <a href="{{ route('teacher.lecture_note.edit', [$subdomain, $lectureNote->id]) }}" 
                               class="inline-block mt-3 px-3 py-1 text-xs bg-yellow-100 text-yellow-700 rounded-lg hover:bg-yellow-200">
                                <i class="fa fa-pen mr-1"></i> Edit Note
                            </a>
                        </div>
                    @else
                        <div class="bg-gray-50 rounded-xl p-6 text-slate-700 leading-relaxed lecture-content prose prose-sm max-w-none">
                            {!! nl2br(e($lectureNote->content)) !!}
                        </div>
                    @endif
                </div>
            @elseif($lectureNote->file_path)
                <div class="border-t border-gray-100 pt-6">
                    <div class="bg-gray-50 rounded-xl p-6 text-center">
                        <i class="fa fa-file-pdf text-red-500 text-5xl mb-3"></i>
                        <p class="text-sm font-semibold text-slate-700">{{ $lectureNote->file_name }}</p>
                        <a href="{{ Storage::url($lectureNote->file_path) }}" target="_blank" class="inline-flex items-center gap-2 mt-3 px-4 py-2 text-sm font-semibold text-black bg-red-600 rounded-lg hover:bg-red-700">
                            <i class="fa fa-download text-black"></i> Download File
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
    /* Hide everything except printArea */
    body > *:not(#printArea) {
        display: none !important;
    }
    
    aside, nav, header, footer,
    [class*="sidenav"], [class*="sidebar"],
    .no-print {
        display: none !important;
    }

    body, html {
        margin: 0;
        padding: 0;
        background: white !important;
    }

    #printArea {
        display: block !important;
        position: static !important;
        width: 100% !important;
        margin: 0 !important;
        padding: 20px !important;
        box-shadow: none !important;
        border: none !important;
        background: white !important;
        visibility: visible !important;
    }

    #printArea * {
        visibility: visible !important;
        color: black !important;
        background: white !important;
        box-shadow: none !important;
        border-color: #e2e8f0 !important;
    }

    .lecture-content {
        white-space: pre-wrap !important;
        word-wrap: break-word !important;
        font-size: 12pt !important;
        line-height: 1.6 !important;
        color: black !important;
        background: white !important;
    }
}
</style>

<script>
function printLectureNote() {
    const originalTitle = document.title;
    document.title = "{{ $lectureNote->title }} - Lecture Note";
    window.print();
    document.title = originalTitle;
}
</script>

@endsection