@extends('layouts.admin')

@section('content')

@php $subdomain = request()->route('subdomain'); @endphp

<div class="w-full px-6 py-6 mx-auto">
    
    <div class="flex flex-wrap items-center justify-between mb-6 -mx-3">
        <div class="px-3">
            <h3 class="text-2xl font-bold text-slate-700 mb-1">Edit Exam Entry</h3>
            <p class="text-sm text-slate-400">
                <i class="fa fa-home mr-1"></i> Dashboard
                <span class="mx-1 text-slate-300">/</span>
                <a href="{{ route('tenant.exam.index', $subdomain) }}" class="hover:text-slate-600">Exam Management</a>
                <span class="mx-1 text-slate-300">/</span>
                <span class="text-slate-600">Edit Entry</span>
            </p>
        </div>
        <div class="px-3 mt-3 md:mt-0">
            <a href="{{ route('tenant.exam.index', $subdomain) }}"
               class="px-4 py-2 text-sm border border-gray-300 rounded-lg text-slate-600 hover:bg-gray-50 transition-all">
                <i class="fa fa-arrow-left mr-1"></i> Back to Exam
            </a>
        </div>
    </div>

    <div class="bg-white shadow-soft-xl rounded-2xl overflow-hidden">
        
        <div class="flex items-center gap-3 px-6 py-4 border-b border-gray-100">
            <div class="w-8 h-8 rounded-lg bg-gradient-to-tl from-amber-500 to-orange-400 flex items-center justify-center shadow-soft-md">
                <i class="fa fa-edit text-black text-xs"></i>
            </div>
            <div>
                <h6 class="font-bold text-slate-700 mb-0">Edit Exam Entry</h6>
                <p class="text-xs text-slate-400 mt-0.5">Update exam information</p>
            </div>
        </div>

        <form method="POST" action="{{ route('tenant.exam.update', [$subdomain, $exam->id]) }}" class="p-6">
            @csrf
            @method('POST')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                {{-- Class --}}
                <div>
                    <label class="block text-xs font-semibold text-slate-600 mb-1.5">
                        <i class="fa fa-chalkboard mr-1 text-slate-400"></i> Class <span class="text-red-500">*</span>
                    </label>
                    <select name="class_id" required
                            class="text-sm w-full rounded-lg border border-gray-300 bg-white py-2.5 px-3 text-gray-700 focus:outline-none focus:border-fuchsia-300 focus:ring-1 focus:ring-fuchsia-200 transition-all">
                        <option value="">-- Select Class --</option>
                        @foreach($classes as $class)
                            <option value="{{ $class->id }}" {{ $exam->class_id == $class->id ? 'selected' : '' }}>
                                {{ $class->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('class_id') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                </div>

                {{-- Subject --}}
                <div>
                    <label class="block text-xs font-semibold text-slate-600 mb-1.5">
                        <i class="fa fa-book mr-1 text-slate-400"></i> Subject <span class="text-red-500">*</span>
                    </label>
                    <select name="subject_id" required
                            class="text-sm w-full rounded-lg border border-gray-300 bg-white py-2.5 px-3 text-gray-700 focus:outline-none focus:border-fuchsia-300 focus:ring-1 focus:ring-fuchsia-200 transition-all">
                        <option value="">-- Select Subject --</option>
                        @foreach($subjects as $subject)
                            <option value="{{ $subject->id }}" {{ $exam->subject_id == $subject->id ? 'selected' : '' }}>
                                {{ $subject->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('subject_id') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                </div>

                {{-- Term --}}
                <div>
                    <label class="block text-xs font-semibold text-slate-600 mb-1.5">
                        <i class="fa fa-calendar-alt mr-1 text-slate-400"></i> Term <span class="text-red-500">*</span>
                    </label>
                    <select name="term" required
                            class="text-sm w-full rounded-lg border border-gray-300 bg-white py-2.5 px-3 text-gray-700 focus:outline-none focus:border-fuchsia-300 focus:ring-1 focus:ring-fuchsia-200 transition-all">
                        <option value="">-- Select Term --</option>
                        <option value="1st" {{ $exam->term == '1st' ? 'selected' : '' }}>1st Term</option>
                        <option value="2nd" {{ $exam->term == '2nd' ? 'selected' : '' }}>2nd Term</option>
                        <option value="3rd" {{ $exam->term == '3rd' ? 'selected' : '' }}>3rd Term</option>
                    </select>
                    @error('term') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                </div>

                {{-- Session --}}
                <div>
                    <label class="block text-xs font-semibold text-slate-600 mb-1.5">
                        <i class="fa fa-calendar-week mr-1 text-slate-400"></i> Session <span class="text-red-500">*</span>
                    </label>
                    <input type="text"
                           name="session"
                           value="{{ old('session', $exam->session) }}"
                           placeholder="e.g. 2024/2025"
                           required
                           class="text-sm w-full rounded-lg border border-gray-300 bg-white py-2.5 px-3 text-gray-700 focus:outline-none focus:border-fuchsia-300 focus:ring-1 focus:ring-fuchsia-200 transition-all">
                    @error('session') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                </div>

                {{-- Test Type --}}
                <div>
                    <label class="block text-xs font-semibold text-slate-600 mb-1.5">
                        <i class="fa fa-pen mr-1 text-slate-400"></i> Exam Type <span class="text-red-500">*</span>
                    </label>
                    <input type="text"
                           name="type"
                           value="{{ old('type', $exam->type) }}"
                           placeholder="e.g. 1st CA, 2nd CA, Exam"
                           required
                           class="text-sm w-full rounded-lg border border-gray-300 bg-white py-2.5 px-3 text-gray-700 focus:outline-none focus:border-fuchsia-300 focus:ring-1 focus:ring-fuchsia-200 transition-all">
                    @error('type') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                </div>

                {{-- Teacher --}}
                <div>
                    <label class="block text-xs font-semibold text-slate-600 mb-1.5">
                        <i class="fa fa-chalkboard-user mr-1 text-slate-400"></i> Teacher <span class="text-red-500">*</span>
                    </label>
                    <select name="teacher_id" required
                            class="text-sm w-full rounded-lg border border-gray-300 bg-white py-2.5 px-3 text-gray-700 focus:outline-none focus:border-fuchsia-300 focus:ring-1 focus:ring-fuchsia-200 transition-all">
                        <option value="">-- Select Teacher --</option>
                        @foreach($teachers as $teacher)
                            <option value="{{ $teacher->id }}" {{ $exam->teacher_id == $teacher->id ? 'selected' : '' }}>
                                {{ $teacher->name }} ({{ $teacher->subject ?? 'N/A' }})
                            </option>
                        @endforeach
                    </select>
                    @error('teacher_id') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                </div>

                {{-- Date --}}
                <div>
                    <label class="block text-xs font-semibold text-slate-600 mb-1.5">
                        <i class="fa fa-calendar mr-1 text-slate-400"></i> Date <span class="text-red-500">*</span>
                    </label>
                    <input type="date"
                           name="date"
                           value="{{ old('date', $exam->date) }}"
                           required
                           class="text-sm w-full rounded-lg border border-gray-300 bg-white py-2.5 px-3 text-gray-700 focus:outline-none focus:border-fuchsia-300 focus:ring-1 focus:ring-fuchsia-200 transition-all">
                    @error('date') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                </div>

                {{-- Start & End Time --}}
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-semibold text-slate-600 mb-1.5">
                            <i class="fa fa-hourglass-start mr-1 text-slate-400"></i> Start Time <span class="text-red-500">*</span>
                        </label>
                        <input type="time"
                               name="start_time"
                               value="{{ old('start_time', $exam->start_time) }}"
                               required
                               class="text-sm w-full rounded-lg border border-gray-300 bg-white py-2.5 px-3 text-gray-700 focus:outline-none focus:border-fuchsia-300 focus:ring-1 focus:ring-fuchsia-200 transition-all">
                        @error('start_time') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-600 mb-1.5">
                            <i class="fa fa-hourglass-end mr-1 text-slate-400"></i> End Time <span class="text-red-500">*</span>
                        </label>
                        <input type="time"
                               name="end_time"
                               value="{{ old('end_time', $exam->end_time) }}"
                               required
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
                    <i class="fa fa-save mr-1"></i> Update Entry
                </button>
            </div>
        </form>
    </div>

</div>

@endsection