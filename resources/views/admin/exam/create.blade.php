@extends('layouts.admin')

@section('content')

@php $subdomain = request()->route('subdomain'); @endphp

<div class="w-full px-6 py-6 mx-auto">
    
    {{-- PAGE HEADER --}}
    <div class="flex flex-wrap items-center justify-between mb-6 -mx-3">
        <div class="px-3">
            <h3 class="text-2xl font-bold text-slate-700 mb-1">Add Exam Entry</h3>
            <p class="text-sm text-slate-400">
                <i class="fa fa-home mr-1"></i> Dashboard
                <span class="mx-1 text-slate-300">/</span>
                <a href="{{ route('tenant.exam.index', $subdomain) }}" class="hover:text-slate-600">Exam Management</a>
                <span class="mx-1 text-slate-300">/</span>
                <span class="text-slate-600">Add Entry</span>
            </p>
        </div>
        <div class="px-3 mt-3 md:mt-0">
            <a href="{{ route('tenant.exam.index', $subdomain) }}"
               class="px-4 py-2 text-sm border border-gray-300 rounded-lg text-slate-600 hover:bg-gray-50 transition-all">
                <i class="fa fa-arrow-left mr-1"></i> Back to Exam
            </a>
        </div>
    </div>

    {{-- Form Card --}}
    <div class="bg-white shadow-soft-xl rounded-2xl overflow-hidden">
        
        <div class="flex items-center gap-3 px-6 py-4 border-b border-gray-100">
            <div class="w-8 h-8 rounded-lg bg-gradient-to-tl from-purple-500 to-pink-400 flex items-center justify-center shadow-soft-md">
                <i class="fa fa-plus-circle text-info text-xs"></i>
            </div>
            <div>
                <h6 class="font-bold text-slate-700 mb-0">New Exam Entry</h6>
                <p class="text-xs text-slate-400 mt-0.5">Schedule a subject for a specific class</p>
            </div>
        </div>

        <form method="POST" action="{{ route('tenant.exam.store', $subdomain) }}" class="p-6">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                {{-- Class Selection --}}
                <div>
                    <label class="block text-xs font-semibold text-slate-600 mb-1.5">
                        <i class="fa fa-chalkboard mr-1 text-slate-400"></i> Class <span class="text-red-500">*</span>
                    </label>
                    <select name="class_id" required
                            class="text-sm w-full rounded-lg border border-gray-300 bg-white py-2.5 px-3 text-gray-700 focus:outline-none focus:border-fuchsia-300 focus:ring-1 focus:ring-fuchsia-200 transition-all">
                        <option value="">-- Select Class --</option>
                        @foreach($classes as $class)
                            <option value="{{ $class->id }}" {{ old('class_id') == $class->id ? 'selected' : '' }}>
                                {{ $class->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('class_id') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                </div>

                {{-- Subject Selection --}}
                <div>
                    <label class="block text-xs font-semibold text-slate-600 mb-1.5">
                        <i class="fa fa-book mr-1 text-slate-400"></i> Subject <span class="text-red-500">*</span>
                    </label>
                    <select name="subject_id" required
                            class="text-sm w-full rounded-lg border border-gray-300 bg-white py-2.5 px-3 text-gray-700 focus:outline-none focus:border-fuchsia-300 focus:ring-1 focus:ring-fuchsia-200 transition-all">
                        <option value="">-- Select Subject --</option>
                        @foreach($subjects as $subject)
                            <option value="{{ $subject->id }}" {{ old('subject_id') == $subject->id ? 'selected' : '' }}>
                                {{ $subject->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('subject_id') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                </div>

                {{-- Term Selection --}}
<div>
    <label class="block text-xs font-semibold text-slate-600 mb-1.5">
        <i class="fa fa-calendar-alt mr-1 text-slate-400"></i> Term / Semester <span class="text-red-500">*</span>
    </label>
    <select name="term" required
            class="text-sm w-full rounded-lg border border-gray-300 bg-white py-2.5 px-3 text-gray-700 focus:outline-none focus:border-fuchsia-300 focus:ring-1 focus:ring-fuchsia-200 transition-all">
        <option value="">-- Select Term --</option>
        <option value="1st" {{ old('term') == '1st' ? 'selected' : '' }}>1st</option>
        <option value="2nd" {{ old('term') == '2nd' ? 'selected' : '' }}>2nd</option>
        <option value="3rd" {{ old('term') == '3rd' ? 'selected' : '' }}>3rd</option>
    </select>
    @error('term') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
</div>

{{-- Session Input --}}
<div>
    <label class="block text-xs font-semibold text-slate-600 mb-1.5">
        <i class="fa fa-calendar-week mr-1 text-slate-400"></i> Session <span class="text-red-500">*</span>
    </label>
    <input type="text" 
           name="session" 
           value="{{ old('session') }}"
           placeholder="e.g. 2024/2025"
           required
           class="text-sm w-full rounded-lg border border-gray-300 bg-white py-2.5 px-3 text-gray-700 focus:outline-none focus:border-fuchsia-300 focus:ring-1 focus:ring-fuchsia-200 transition-all">
    @error('session') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
</div>

{{-- Exam Type --}}
<div>
    <label class="block text-xs font-semibold text-slate-600 mb-1.5">
        <i class="fa fa-calendar-week mr-1 text-slate-400"></i> Exam Type <span class="text-red-500">*</span>
    </label>
    <input type="text" 
           name="type" 
           value="{{ old('type') }}"
           placeholder="e.g. 1st Term/Semester"
           required
           class="text-sm w-full rounded-lg border border-gray-300 bg-white py-2.5 px-3 text-gray-700 focus:outline-none focus:border-fuchsia-300 focus:ring-1 focus:ring-fuchsia-200 transition-all">
    @error('type') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
</div>


                {{-- Teacher Selection --}}
<div>
    <label class="block text-xs font-semibold text-slate-600 mb-1.5">
        <i class="fa fa-chalkboard-user mr-1 text-slate-400"></i> Teacher <span class="text-red-500">*</span>
    </label>
    <select name="teacher_id" required
            class="text-sm w-full rounded-lg border border-gray-300 bg-white py-2.5 px-3 text-gray-700 focus:outline-none focus:border-fuchsia-300 focus:ring-1 focus:ring-fuchsia-200 transition-all">
        <option value="">-- Select Teacher --</option>
        @foreach($teachers as $teacher)
            <option value="{{ $teacher->id }}" {{ old('teacher_id') == $teacher->id ? 'selected' : '' }}>
                {{ $teacher->name }} ({{ $teacher->subject ?? 'N/A' }})
            </option>
        @endforeach
    </select>
    @error('teacher_id') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
</div>

                {{-- Date Selection --}}
<div>
    <label class="block text-xs font-semibold text-slate-600 mb-1.5">
        <i class="fa fa-calendar mr-1 text-slate-400"></i> Date <span class="text-red-500">*</span>
    </label>
    <input type="date" 
           name="date" 
           value="{{ old('date') }}"
           required
           class="text-sm w-full rounded-lg border border-gray-300 bg-white py-2.5 px-3 text-gray-700 focus:outline-none focus:border-fuchsia-300 focus:ring-1 focus:ring-fuchsia-200 transition-all">
    @error('date') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
</div>

                {{-- Time Row (Start & End) --}}
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-semibold text-slate-600 mb-1.5">
                            <i class="fa fa-hourglass-start mr-1 text-slate-400"></i> Start Time <span class="text-red-500">*</span>
                        </label>
                        <input type="time" name="start_time" value="{{ old('start_time') }}" required
                               class="text-sm w-full rounded-lg border border-gray-300 bg-white py-2.5 px-3 text-gray-700 focus:outline-none focus:border-fuchsia-300 focus:ring-1 focus:ring-fuchsia-200 transition-all">
                        @error('start_time') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-600 mb-1.5">
                            <i class="fa fa-hourglass-end mr-1 text-slate-400"></i> End Time <span class="text-red-500">*</span>
                        </label>
                        <input type="time" name="end_time" value="{{ old('end_time') }}" required
                               class="text-sm w-full rounded-lg border border-gray-300 bg-white py-2.5 px-3 text-gray-700 focus:outline-none focus:border-fuchsia-300 focus:ring-1 focus:ring-fuchsia-200 transition-all">
                        @error('end_time') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>
            </div>

            {{-- Form Actions --}}
            <div class="flex items-center justify-end gap-3 mt-6 pt-4 border-t border-gray-100">
                <a href="{{ route('tenant.exam.index', $subdomain) }}"
                   class="px-6 py-2.5 text-sm font-semibold text-slate-600 border border-gray-300 rounded-lg hover:bg-gray-50 transition-all">
                    <i class="fa fa-times mr-1"></i> Cancel
                </a>
                <button type="submit"
                        class="px-6 py-2.5 text-sm font-semibold text-white rounded-lg bg-gradient-to-tl from-blue-600 to-cyan-500 shadow-soft-md hover:shadow-soft-xl hover:scale-105 transition-all">
                    <i class="fa fa-save mr-1"></i> Save Exam Entry
                </button>
            </div>
        </form>
    </div>

    {{-- Info Card --}}
    <div class="mt-5 p-4 bg-gradient-to-r from-blue-50 to-cyan-50 rounded-xl border border-blue-100">
        <div class="flex items-start gap-3">
            <div class="w-8 h-8 rounded-lg bg-gradient-to-tl from-blue-500 to-cyan-400 flex items-center justify-center flex-shrink-0">
                <i class="fa fa-info-circle text-info text-xs"></i>
            </div>
            <div>
                <p class="text-sm font-semibold text-blue-800">Information</p>
                <p class="text-xs text-blue-600 mt-0.5">
                    Schedule subjects for specific classes. Make sure time slots do not overlap for the same class.
                </p>
            </div>
        </div>
    </div>

</div>

@endsection