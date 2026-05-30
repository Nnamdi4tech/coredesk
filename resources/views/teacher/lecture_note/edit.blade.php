{{-- resources/views/teacher/lecture_note/edit.blade.php --}}
@extends('layouts.admin')

@section('content')

@php $subdomain = request()->route('subdomain'); @endphp

<div class="w-full px-6 py-6 mx-auto">
    <div class="flex items-center justify-between mb-6">
        <div>
            <h3 class="text-2xl font-bold text-slate-700 mb-1">Edit Lecture Note</h3>
            <p class="text-sm text-slate-400">Update your lecture note</p>
        </div>
        <a href="{{ route('teacher.lecture_note.index', $subdomain) }}" class="px-4 py-2 text-sm border border-gray-300 rounded-lg text-slate-600 hover:bg-gray-50">Back</a>
    </div>

    @if($errors->any())
    <div class="p-4 mb-6 text-sm text-red-700 bg-red-50 border border-red-200 rounded-2xl">
        <ul class="list-disc list-inside">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
    </div>
    @endif

    <form method="POST" action="{{ route('teacher.lecture_note.update', [$subdomain, $lectureNote->id]) }}" enctype="multipart/form-data">
        @csrf @method('PUT')

        <div class="bg-white shadow-soft-xl rounded-2xl p-6 mb-5">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div>
                    <label class="block text-xs font-semibold text-slate-600 mb-1.5">Class <span class="text-red-500">*</span></label>
                    <select name="class_id" required class="text-sm w-full rounded-lg border border-gray-300 bg-white py-2 px-3">
                        @foreach($classes as $class)
                            <option value="{{ $class->id }}" {{ $lectureNote->class_id == $class->id ? 'selected' : '' }}>{{ $class->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-600 mb-1.5">Subject <span class="text-red-500">*</span></label>
                    <select name="subject_id" required class="text-sm w-full rounded-lg border border-gray-300 bg-white py-2 px-3">
                        @foreach($subjects as $subject)
                            <option value="{{ $subject->id }}" {{ $lectureNote->subject_id == $subject->id ? 'selected' : '' }}>{{ $subject->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="md:col-span-2">
                    <label class="block text-xs font-semibold text-slate-600 mb-1.5">Title <span class="text-red-500">*</span></label>
                    <input type="text" name="title" value="{{ old('title', $lectureNote->title) }}" required class="text-sm w-full rounded-lg border border-gray-300 bg-white py-2 px-3">
                </div>
                <div class="md:col-span-2">
                    <label class="block text-xs font-semibold text-slate-600 mb-1.5">Note Type</label>
                    <div class="flex gap-4">
                        <label class="flex items-center gap-2"><input type="radio" name="type" value="text" {{ $lectureNote->type == 'text' ? 'checked' : '' }}> Text</label>
                        <label class="flex items-center gap-2"><input type="radio" name="type" value="file" {{ $lectureNote->type == 'file' ? 'checked' : '' }}> File Upload</label>
                    </div>
                </div>
                <div class="md:col-span-2" id="textContentDiv" style="{{ $lectureNote->type == 'text' ? 'display:block' : 'display:none' }}">
                    <label class="block text-xs font-semibold text-slate-600 mb-1.5">Content</label>
                    <textarea name="content" rows="10" class="text-sm w-full rounded-lg border border-gray-300 bg-white py-2 px-3">{{ old('content', $lectureNote->content) }}</textarea>
                </div>
                <div class="md:col-span-2" id="fileUploadDiv" style="{{ $lectureNote->type == 'file' ? 'display:block' : 'display:none' }}">
                    <label class="block text-xs font-semibold text-slate-600 mb-1.5">Upload New File (optional)</label>
                    <input type="file" name="file" accept=".pdf,.doc,.docx,.txt" class="text-sm w-full rounded-lg border border-gray-300 bg-white py-2 px-3">
                    @if($lectureNote->file_name)
                        <p class="text-xs text-slate-500 mt-1">Current file: {{ $lectureNote->file_name }}</p>
                    @endif
                </div>
            </div>
        </div>

        <div class="flex items-center justify-between">
            <a href="{{ route('teacher.lecture_note.index', $subdomain) }}" class="px-6 py-2.5 text-sm border border-gray-300 rounded-lg text-slate-600 hover:bg-gray-50">Cancel</a>
            <button type="submit" class="px-8 py-2.5 text-sm font-semibold text-white rounded-lg bg-gradient-to-tl from-amber-500 to-orange-500 shadow-soft-md hover:shadow-soft-xl hover:scale-105 transition-all">Update & Resubmit</button>
        </div>
    </form>
</div>

<script>
document.querySelectorAll('input[name="type"]').forEach(radio => {
    radio.addEventListener('change', function() {
        document.getElementById('textContentDiv').style.display = this.value === 'text' ? 'block' : 'none';
        document.getElementById('fileUploadDiv').style.display = this.value === 'file' ? 'block' : 'none';
    });
});
</script>

@endsection