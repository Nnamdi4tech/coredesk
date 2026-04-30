@extends('layouts.admin')

@section('content')

@php $subdomain = request()->route('subdomain'); @endphp

<div class="w-full px-6 py-6 mx-auto">

    {{-- PAGE HEADER --}}
    <div class="flex flex-wrap items-center justify-between mb-6 -mx-3">
        <div class="px-3">
            <h3 class="text-2xl font-bold text-slate-700 mb-1">Edit Subject</h3>
            <p class="text-sm text-slate-400">
                <i class="fa fa-home mr-1"></i> Dashboard
                <span class="mx-1 text-slate-300">/</span>
                <a href="{{ route('tenant.subjects.index', $subdomain) }}" class="text-slate-500 hover:text-slate-700">Subjects</a>
                <span class="mx-1 text-slate-300">/</span>
                <span class="text-slate-600">Edit</span>
            </p>
        </div>
        <div class="px-3">
            <a href="{{ route('tenant.subjects.index', $subdomain) }}"
               class="px-5 py-2 text-sm font-semibold text-slate-600 rounded-lg border border-gray-200 hover:bg-gray-50 transition-all">
                <i class="fa fa-arrow-left mr-1"></i> Back to Subjects
            </a>
        </div>
    </div>

    {{-- ERROR MESSAGES --}}
    @if($errors->any())
        <div class="p-4 mb-6 text-sm text-red-700 bg-red-50 border border-red-200 rounded-2xl">
            <ul class="list-disc list-inside">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="bg-white rounded-2xl shadow-soft-xl overflow-hidden">

        <div class="px-6 py-4 border-b border-gray-100">
            <h6 class="font-bold text-slate-700">Subject Details</h6>
            <p class="text-xs text-slate-400 mt-0.5">Update the subject information below</p>
        </div>

        <form method="POST" action="{{ route('tenant.subjects.update', [$subdomain, $subject->id]) }}" class="p-6">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                {{-- Subject Name --}}
                <div class="flex flex-col gap-1">
                    <label class="text-xs font-semibold text-slate-500 uppercase tracking-wider">
                        Subject Name <span class="text-red-400">*</span>
                    </label>
                    <input type="text"
                           name="name"
                           value="{{ old('name', $subject->name) }}"
                           placeholder="e.g. Mathematics"
                           class="text-sm border border-gray-200 rounded-lg px-3 py-2.5 focus:outline-none focus:border-blue-400 text-slate-700"
                           required />
                </div>

                {{-- Course Code --}}
                <div class="flex flex-col gap-1">
                    <label class="text-xs font-semibold text-slate-500 uppercase tracking-wider">
                        Course Code
                    </label>
                    <input type="text"
                           name="course_code"
                           value="{{ old('course_code', $subject->course_code) }}"
                           placeholder="e.g. MTH101"
                           class="text-sm border border-gray-200 rounded-lg px-3 py-2.5 focus:outline-none focus:border-blue-400 text-slate-700" />
                </div>

                {{-- Assign Teacher --}}
                <div class="flex flex-col gap-1">
                    <label class="text-xs font-semibold text-slate-500 uppercase tracking-wider">
                        Assign Teacher
                    </label>
                    <select name="teacher_id"
                            class="text-sm border border-gray-200 rounded-lg px-3 py-2.5 focus:outline-none focus:border-blue-400 text-slate-700">
                        <option value="">— No Teacher —</option>
                        @foreach($teachers as $teacher)
                            <option value="{{ $teacher->id }}"
                                {{ old('teacher_id', $assignment->teacher_id ?? '') == $teacher->id ? 'selected' : '' }}>
                                {{ $teacher->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Assign Class --}}
                <div class="flex flex-col gap-1">
                    <label class="text-xs font-semibold text-slate-500 uppercase tracking-wider">
                        Assign Class <span class="text-red-400">*</span>
                    </label>
                    <select name="class_id"
                            class="text-sm border border-gray-200 rounded-lg px-3 py-2.5 focus:outline-none focus:border-blue-400 text-slate-700"
                            required>
                        <option value="">— Select Class —</option>
                        @foreach($classes as $class)
                            <option value="{{ $class->id }}"
                                {{ old('class_id', $assignment->class_id ?? '') == $class->id ? 'selected' : '' }}>
                                {{ $class->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Description --}}
                <div class="flex flex-col gap-1 md:col-span-2">
                    <label class="text-xs font-semibold text-slate-500 uppercase tracking-wider">
                        Description
                    </label>
                    <textarea name="description"
                              rows="3"
                              placeholder="Brief description of the subject..."
                              class="text-sm border border-gray-200 rounded-lg px-3 py-2.5 focus:outline-none focus:border-blue-400 text-slate-700 resize-none">{{ old('description', $subject->description) }}</textarea>
                </div>

            </div>

            {{-- Actions --}}
            <div class="flex items-center gap-3 mt-6 pt-6 border-t border-gray-100">
                <button type="submit"
                        class="px-6 py-2.5 text-sm font-semibold text-white rounded-lg bg-gradient-to-tl from-blue-600 to-cyan-500 shadow-soft-sm hover:scale-105 transition-all">
                    <i class="fa fa-save mr-1"></i> Save Changes
                </button>
                <a href="{{ route('tenant.subjects.index', $subdomain) }}"
                   class="px-6 py-2.5 text-sm font-semibold text-slate-600 rounded-lg border border-gray-200 hover:bg-gray-50 transition-all">
                    Cancel
                </a>
            </div>

        </form>
    </div>

</div>

@endsection