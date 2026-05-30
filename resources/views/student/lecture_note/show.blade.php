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
        <a href="{{ route('student.lecture_note.index', $subdomain) }}" class="px-4 py-2 text-sm border border-gray-300 rounded-lg text-slate-600 hover:bg-gray-50">Back</a>
    </div>

    <div class="bg-white shadow-soft-xl rounded-2xl overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100 bg-gradient-to-r from-blue-50 to-cyan-50">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-lg bg-gradient-to-tl from-blue-500 to-cyan-400 flex items-center justify-center"><i class="fa fa-book text-black text-sm"></i></div>
                <div>
                    <h6 class="font-bold text-slate-700 mb-0">{{ $lectureNote->title }}</h6>
                    <p class="text-xs text-slate-400">By {{ $lectureNote->teacher->name ?? 'N/A' }} • {{ $lectureNote->created_at->format('M d, Y') }}</p>
                </div>
            </div>
        </div>

        <div class="p-6">
            @if($lectureNote->type === 'text')
                <div class="bg-gray-50 rounded-xl p-4 text-slate-700 leading-relaxed">{!! nl2br(e($lectureNote->content)) !!}</div>
            @elseif($lectureNote->file_path)
                <div class="bg-gray-50 rounded-xl p-6 text-center">
                    <i class="fa fa-file-pdf text-red-500 text-5xl mb-3"></i>
                    <p class="text-sm font-semibold text-slate-700">{{ $lectureNote->file_name }}</p>
                    <a href="{{ Storage::url($lectureNote->file_path) }}" target="_blank" class="inline-flex items-center gap-2 mt-3 px-4 py-2 text-sm font-semibold text-white bg-red-600 rounded-lg hover:bg-red-700">Download File</a>
                </div>
            @endif
        </div>
    </div>
</div>

@endsection