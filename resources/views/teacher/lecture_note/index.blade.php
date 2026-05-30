{{-- resources/views/teacher/lecture_note/index.blade.php --}}
@extends('layouts.admin')

@section('content')

@php $subdomain = request()->route('subdomain'); @endphp

<div class="w-full px-6 py-6 mx-auto">
    <div class="flex flex-wrap items-center justify-between mb-6 -mx-3">
        <div class="px-3">
            <h3 class="text-2xl font-bold text-slate-700 mb-1">My Lecture Notes</h3>
            <p class="text-sm text-slate-400">
                <i class="fa fa-home mr-1"></i> Dashboard
                <span class="mx-1 text-slate-300">/</span>
                <span class="text-slate-600">Lecture Notes</span>
            </p>
        </div>
        <div class="px-3 mt-3 md:mt-0">
            <a href="{{ route('teacher.lecture_note.create', $subdomain) }}" class="px-5 py-2 text-sm font-semibold text-white rounded-lg bg-gradient-to-tl from-green-600 to-emerald-500 shadow-soft-md hover:shadow-soft-xl hover:scale-105 transition-all">
                <i class="fa fa-plus mr-1"></i> Add Lecture Note
            </a>
        </div>
    </div>

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

    <div class="flex flex-wrap -mx-3 mb-6">
        <div class="w-full max-w-full px-3 mb-6 sm:w-1/2 sm:flex-none xl:mb-0 xl:w-1/4">
            <div class="relative flex flex-col min-w-0 break-words bg-white shadow-soft-xl rounded-2xl bg-clip-border">
                <div class="flex-auto p-4">
                    <div class="flex flex-row -mx-3">
                        <div class="flex-none w-2/3 max-w-full px-3">
                            <div><p class="mb-0 font-sans text-sm font-semibold leading-normal">Total Notes</p><h5 class="mb-0 font-bold">{{ $totalNotes }}</h5></div>
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
                            <div><p class="mb-0 font-sans text-sm font-semibold leading-normal">Approved</p><h5 class="mb-0 font-bold text-green-600">{{ $approvedNotes }}</h5></div>
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
        <div class="w-full max-w-full px-3 mb-6 sm:w-1/2 sm:flex-none xl:mb-0 xl:w-1/4">
            <div class="relative flex flex-col min-w-0 break-words bg-white shadow-soft-xl rounded-2xl bg-clip-border">
                <div class="flex-auto p-4">
                    <div class="flex flex-row -mx-3">
                        <div class="flex-none w-2/3 max-w-full px-3">
                            <div><p class="mb-0 font-sans text-sm font-semibold leading-normal">Pending</p><h5 class="mb-0 font-bold text-orange-600">{{ $pendingNotes }}</h5></div>
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
        <div class="w-full max-w-full px-3 sm:w-1/2 sm:flex-none xl:w-1/4">
            <div class="relative flex flex-col min-w-0 break-words bg-white shadow-soft-xl rounded-2xl bg-clip-border">
                <div class="flex-auto p-4">
                    <div class="flex flex-row -mx-3">
                        <div class="flex-none w-2/3 max-w-full px-3">
                            <div><p class="mb-0 font-sans text-sm font-semibold leading-normal">Rejected</p><h5 class="mb-0 font-bold text-red-600">{{ $rejectedNotes }}</h5></div>
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

    <div class="bg-white shadow-soft-xl rounded-2xl overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100">
            <h6 class="font-bold text-slate-700">My Lecture Notes</h6>
        </div>

        @if($lectureNotes->count() > 0)
        <div class="overflow-x-auto">
            <table class="items-center w-full mb-0 align-top border-gray-200 text-slate-500">
                <thead class="align-bottom bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xxs font-bold uppercase tracking-wider">Class</th>
                        <th class="px-6 py-3 text-left text-xxs font-bold uppercase tracking-wider">Subject</th>
                        <th class="px-6 py-3 text-left text-xxs font-bold uppercase tracking-wider">Title</th>
                        <th class="px-6 py-3 text-left text-xxs font-bold uppercase tracking-wider">Type</th>
                        <th class="px-6 py-3 text-left text-xxs font-bold uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-center text-xxs font-bold uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($lectureNotes as $note)
                    <tr class="border-t border-gray-100 hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4 text-sm">{{ $note->class->name ?? 'N/A' }}</td>
                        <td class="px-6 py-4 text-sm">{{ $note->subject->name ?? 'N/A' }}</td>
                        <td class="px-6 py-4 text-sm font-semibold text-slate-700">{{ Str::limit($note->title, 40) }}</td>
                        <td class="px-6 py-4">
                            @if($note->type === 'text')
                                <span class="text-xs px-2 py-1 rounded-full bg-blue-50 text-blue-600"><i class="fa fa-pencil-alt mr-1"></i> Text</span>
                            @else
                                <span class="text-xs px-2 py-1 rounded-full bg-purple-50 text-purple-600"><i class="fa fa-file-pdf mr-1"></i> File</span>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            @if($note->approved)
                                <span class="text-xs font-semibold bg-green-50 text-green-600 px-2.5 py-1 rounded-full"><i class="fa fa-check-circle mr-1"></i> Approved</span>
                            @elseif($note->rejected)
                                <span class="text-xs font-semibold bg-red-50 text-red-600 px-2.5 py-1 rounded-full"><i class="fa fa-times-circle mr-1"></i> Rejected</span>
                            @else
                                <span class="text-xs font-semibold bg-orange-50 text-orange-600 px-2.5 py-1 rounded-full"><i class="fa fa-clock mr-1"></i> Pending</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-center">
                            <div class="flex items-center justify-center gap-2">
                                <a href="{{ route('teacher.lecture_note.view', [$subdomain, $note->id]) }}" class="w-7 h-7 rounded-lg bg-blue-50 text-blue-500 flex items-center justify-center hover:bg-blue-100"><i class="fa fa-eye text-xs"></i></a>
                                @if(!$note->approved)
                                <a href="{{ route('teacher.lecture_note.edit', [$subdomain, $note->id]) }}" class="w-7 h-7 rounded-lg bg-amber-50 text-amber-500 flex items-center justify-center hover:bg-amber-100"><i class="fa fa-pen text-xs"></i></a>
                                <form method="POST" action="{{ route('teacher.lecture_note.destroy', [$subdomain, $note->id]) }}" onsubmit="return confirm('Delete this lecture note?')" class="inline">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="w-7 h-7 rounded-lg bg-red-50 text-red-500 flex items-center justify-center hover:bg-red-100"><i class="fa fa-trash text-xs"></i></button>
                                </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
        <div class="p-12 text-center">
            <div class="w-20 h-20 rounded-2xl bg-gray-100 flex items-center justify-center mb-4 mx-auto"><i class="fa fa-book-open text-gray-400 text-3xl"></i></div>
            <p class="text-slate-500 font-semibold text-lg">No lecture notes yet</p>
            <p class="text-slate-400 text-sm mt-1">Click "Add Lecture Note" to create your first one.</p>
        </div>
        @endif
    </div>
</div>

@endsection