{{-- resources/views/teacher/lecture_note/create.blade.php --}}
@extends('layouts.admin')

@section('content')

@php $subdomain = request()->route('subdomain'); @endphp

<div class="w-full px-6 py-6 mx-auto">
    <div class="flex items-center justify-between mb-6">
        <div>
            <h3 class="text-2xl font-bold text-slate-700 mb-1">Add Lecture Note</h3>
            <p class="text-sm text-slate-400">
                <i class="fa fa-home mr-1"></i> Dashboard
                <span class="mx-1 text-slate-300">/</span>
                <a href="{{ route('teacher.lecture-note.index', $subdomain) }}" class="hover:text-slate-600">Lecture Notes</a>
                <span class="mx-1 text-slate-300">/</span>
                <span class="text-slate-600">Add</span>
            </p>
        </div>
        <a href="{{ route('teacher.lecture-note.index', $subdomain) }}" class="px-4 py-2 text-sm border border-gray-300 rounded-lg text-slate-600 hover:bg-gray-50">Back</a>
    </div>

    @if($errors->any())
    <div class="p-4 mb-6 text-sm text-red-700 bg-red-50 border border-red-200 rounded-2xl">
        <ul class="list-disc list-inside">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
    </div>
    @endif

    <form method="POST" action="{{ route('teacher.lecture-note.store', $subdomain) }}" enctype="multipart/form-data">
        @csrf

        <div class="bg-white shadow-soft-xl rounded-2xl p-6 mb-5">
            <div class="flex items-center gap-3 mb-5 pb-4 border-b border-gray-100">
                <div class="w-8 h-8 rounded-lg bg-gradient-to-tl from-purple-500 to-pink-400 flex items-center justify-center"><i class="fa fa-book-open text-black text-xs"></i></div>
                <div><h6 class="font-bold text-slate-700">Lecture Note Information</h6><p class="text-xs text-slate-400">Fill in the lecture note details</p></div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div>
                    <label class="block text-xs font-semibold text-slate-600 mb-1.5">Class <span class="text-red-500">*</span></label>
                    <select name="class_id" required class="text-sm w-full rounded-lg border border-gray-300 bg-white py-2 px-3">
                        <option value="">-- Select Class --</option>
                        @foreach($classes as $class)
                            <option value="{{ $class->id }}" {{ old('class_id') == $class->id ? 'selected' : '' }}>{{ $class->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-600 mb-1.5">Subject <span class="text-red-500">*</span></label>
                    <select name="subject_id" required class="text-sm w-full rounded-lg border border-gray-300 bg-white py-2 px-3">
                        <option value="">-- Select Subject --</option>
                        @foreach($subjects as $subject)
                            <option value="{{ $subject->id }}" {{ old('subject_id') == $subject->id ? 'selected' : '' }}>{{ $subject->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="md:col-span-2">
                    <label class="block text-xs font-semibold text-slate-600 mb-1.5">Title <span class="text-red-500">*</span></label>
                    <input type="text" name="title" value="{{ old('title') }}" required placeholder="e.g., Introduction to Algebra" class="text-sm w-full rounded-lg border border-gray-300 bg-white py-2 px-3 focus:outline-none focus:border-fuchsia-300">
                </div>

                <div class="md:col-span-2">
                    <label class="block text-xs font-semibold text-slate-600 mb-1.5">Note Type <span class="text-red-500">*</span></label>
                    <div class="flex gap-4">
                        <label class="flex items-center gap-2"><input type="radio" name="type" value="text" {{ old('type', 'text') == 'text' ? 'checked' : '' }}> <span class="text-sm">Write Text</span></label>
                        <label class="flex items-center gap-2"><input type="radio" name="type" value="file" {{ old('type') == 'file' ? 'checked' : '' }}> <span class="text-sm">Upload File (PDF/DOC)</span></label>
                    </div>
                </div>

                <div class="md:col-span-2" id="textContentDiv">
                    <label class="block text-xs font-semibold text-slate-600 mb-1.5">Content <span class="text-red-500">*</span></label>
                    <textarea name="content" rows="10" placeholder="Write your lecture note content here..." class="text-sm w-full rounded-lg border border-gray-300 bg-white py-2 px-3 focus:outline-none focus:border-fuchsia-300">{{ old('content') }}</textarea>
                </div>

                <div class="md:col-span-2" id="fileUploadDiv" style="display:none;">
                    <label class="block text-xs font-semibold text-slate-600 mb-1.5">Upload File <span class="text-red-500">*</span></label>
                    <input type="file" name="file" accept=".pdf,.doc,.docx,.txt" class="text-sm w-full rounded-lg border border-gray-300 bg-white py-2 px-3">
                    <p class="text-xs text-slate-400 mt-1">Accepted formats: PDF, DOC, DOCX, TXT (Max 10MB)</p>
                </div>
            </div>
        </div>

        <div class="flex items-center justify-between">
            <a href="{{ route('teacher.lecture-note.index', $subdomain) }}" class="px-6 py-2.5 text-sm border border-gray-300 rounded-lg text-slate-600 hover:bg-gray-50">Cancel</a>
            <button type="submit" class="px-8 py-2.5 text-sm font-semibold text-white rounded-lg bg-gradient-to-tl from-green-600 to-emerald-500 shadow-soft-md hover:shadow-soft-xl hover:scale-105 transition-all">Submit for Approval</button>
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