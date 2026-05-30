{{-- resources/views/student/lecture_note/show.blade.php --}}
@extends('layouts.admin')

@section('content')

@php $subdomain = request()->route('subdomain'); @endphp

<div class="w-full px-6 py-6 mx-auto">
    <div class="flex items-center justify-between mb-6">
        <div>
            <h3 class="text-2xl font-bold text-slate-700 mb-1">{{ $lectureNote->title }}</h3>
            <p class="text-sm text-slate-400">Lecture Note</p>
        </div>
        <div class="flex gap-2">
            @if($lectureNote->type === 'text' && !empty(trim($lectureNote->content ?? '')))
                <button onclick="printLectureNote()"
                        class="px-4 py-2 text-sm font-semibold text-white rounded-lg bg-gradient-to-tl from-blue-600 to-cyan-500 shadow-soft-md hover:shadow-soft-xl hover:scale-105 transition-all">
                    <i class="fa fa-print mr-1"></i> Print
                </button>
            @endif
            <a href="{{ route('student.lecture_note.index', $subdomain) }}" class="px-4 py-2 text-sm border border-gray-300 rounded-lg text-slate-600 hover:bg-gray-50">
                <i class="fa fa-arrow-left mr-1"></i> Back
            </a>
        </div>
    </div>

    <div class="bg-white shadow-soft-xl rounded-2xl overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100 bg-gradient-to-r from-blue-50 to-cyan-50">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-lg bg-gradient-to-tl from-blue-500 to-cyan-400 flex items-center justify-center">
                    <i class="fa fa-book text-black text-sm"></i>
                </div>
                <div>
                    <h6 class="font-bold text-slate-700 mb-0">{{ $lectureNote->title }}</h6>
                    <p class="text-xs text-slate-400">By {{ $lectureNote->teacher->name ?? 'N/A' }} • {{ $lectureNote->created_at->format('M d, Y') }}</p>
                </div>
            </div>
        </div>

        <div class="p-6">
            @if($lectureNote->type === 'text')
                <div class="bg-gray-50 rounded-xl p-4 text-slate-700 leading-relaxed lecture-content">
                    {!! nl2br(e($lectureNote->content)) !!}
                </div>
            @elseif($lectureNote->file_path)
                <div class="bg-gray-50 rounded-xl p-6 text-center">
                    <i class="fa fa-file-pdf text-red-500 text-5xl mb-3"></i>
                    <p class="text-sm font-semibold text-slate-700">{{ $lectureNote->file_name }}</p>
                    <a href="{{ Storage::url($lectureNote->file_path) }}" target="_blank"
                       class="inline-flex items-center gap-2 mt-3 px-4 py-2 text-sm font-semibold text-black bg-red-600 rounded-lg hover:bg-red-700">
                        <i class="fa fa-download text-black"></i> Download File
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>

<script>
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