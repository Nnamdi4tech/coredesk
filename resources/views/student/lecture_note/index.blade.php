{{-- resources/views/student/lecture_note/index.blade.php --}}
@extends('layouts.admin')

@section('content')

@php $subdomain = request()->route('subdomain'); @endphp

<div class="w-full px-6 py-6 mx-auto">
    <div class="mb-6">
        <h3 class="text-2xl font-bold text-slate-700 mb-1">Lecture Notes</h3>
        <p class="text-sm text-slate-400">
            <i class="fa fa-home mr-1"></i> Dashboard
            <span class="mx-1 text-slate-300">/</span>
            <span class="text-slate-600">Lecture Notes</span>
        </p>
    </div>

    @if(session('success'))
        <div class="p-4 mb-6 text-sm text-green-700 bg-green-50 border border-green-200 rounded-2xl">{{ session('success') }}</div>
    @endif

    <div class="flex flex-wrap -mx-3 mb-6">
        <div class="w-full max-w-full px-3 mb-6 sm:w-1/2 sm:flex-none xl:mb-0 xl:w-1/4">
            <div class="bg-white shadow-soft-xl rounded-2xl p-4">
                <p class="text-xs text-slate-400">Total Notes</p>
                <h5 class="text-2xl font-bold text-slate-700">{{ $totalNotes }}</h5>
            </div>
        </div>
        <div class="w-full max-w-full px-3 mb-6 sm:w-1/2 sm:flex-none xl:mb-0 xl:w-1/4">
            <div class="bg-white shadow-soft-xl rounded-2xl p-4">
                <p class="text-xs text-slate-400">Subjects with Notes</p>
                <h5 class="text-2xl font-bold text-slate-700">{{ $subjectsWithNotes }}</h5>
            </div>
        </div>
    </div>

    @foreach($groupedBySubject as $subjectName => $notes)
    <div class="bg-white shadow-soft-xl rounded-2xl overflow-hidden mb-6">
        <div class="px-6 py-4 border-b border-gray-100 bg-gradient-to-r from-blue-50 to-cyan-50">
            <div class="flex items-center gap-2">
                <div class="w-8 h-8 rounded-lg bg-gradient-to-tl from-blue-500 to-cyan-400 flex items-center justify-center"><i class="fa fa-book text-white text-xs"></i></div>
                <h6 class="font-bold text-slate-700">{{ $subjectName }}</h6>
            </div>
        </div>
        <div class="divide-y divide-gray-100">
            @foreach($notes as $note)
            <div class="p-4 hover:bg-gray-50 transition">
                <a href="{{ route('student.lecture-note.show', [$subdomain, $note->id]) }}" class="block">
                    <div class="flex items-start justify-between">
                        <div class="flex-1">
                            <h5 class="text-sm font-bold text-slate-700 mb-1">{{ $note->title }}</h5>
                            <p class="text-xs text-slate-400">
                                <i class="fa fa-chalkboard-user mr-1"></i> {{ $note->teacher->name ?? 'N/A' }}
                                <span class="mx-2">•</span>
                                <i class="fa fa-calendar mr-1"></i> {{ $note->created_at->format('M d, Y') }}
                            </p>
                        </div>
                        <div class="ml-4">
                            @if($note->type === 'text')
                                <span class="text-xs px-2 py-1 rounded-full bg-blue-50 text-blue-600"><i class="fa fa-pencil-alt mr-1"></i> Text</span>
                            @else
                                <span class="text-xs px-2 py-1 rounded-full bg-purple-50 text-purple-600"><i class="fa fa-file-pdf mr-1"></i> File</span>
                            @endif
                        </div>
                    </div>
                </a>
            </div>
            @endforeach
        </div>
    </div>
    @endforeach

    @if($totalNotes == 0)
    <div class="bg-white shadow-soft-xl rounded-2xl p-12 text-center">
        <div class="w-20 h-20 rounded-2xl bg-gray-100 flex items-center justify-center mb-4 mx-auto"><i class="fa fa-book-open text-gray-400 text-3xl"></i></div>
        <p class="text-slate-500 font-semibold text-lg">No lecture notes available</p>
        <p class="text-slate-400 text-sm mt-1">Your teachers haven't uploaded any lecture notes yet.</p>
    </div>
    @endif
</div>

@endsection