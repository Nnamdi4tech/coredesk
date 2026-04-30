@extends('layouts.admin')

@section('content')

@php $subdomain = request()->route('subdomain'); @endphp

<div class="w-full px-6 py-6 mx-auto">
    
    <div class="flex flex-wrap items-center justify-between mb-6 -mx-3">
        <div class="px-3">
            <h3 class="text-2xl font-bold text-slate-700 mb-1">Edit Timetable Entry</h3>
            <p class="text-sm text-slate-400">
                <i class="fa fa-home mr-1"></i> Dashboard
                <span class="mx-1 text-slate-300">/</span>
                <a href="{{ route('tenant.timetable.index', $subdomain) }}" class="hover:text-slate-600">Timetable Management</a>
                <span class="mx-1 text-slate-300">/</span>
                <span class="text-slate-600">Edit Entry</span>
            </p>
        </div>
        <div class="px-3 mt-3 md:mt-0">
            <a href="{{ route('tenant.timetable.index', $subdomain) }}"
               class="px-4 py-2 text-sm border border-gray-300 rounded-lg text-slate-600 hover:bg-gray-50 transition-all">
                <i class="fa fa-arrow-left mr-1"></i> Back to Timetable
            </a>
        </div>
    </div>

    <div class="bg-white shadow-soft-xl rounded-2xl overflow-hidden">
        
        <div class="flex items-center gap-3 px-6 py-4 border-b border-gray-100">
            <div class="w-8 h-8 rounded-lg bg-gradient-to-tl from-amber-500 to-orange-400 flex items-center justify-center shadow-soft-md">
                <i class="fa fa-edit text-white text-xs"></i>
            </div>
            <div>
                <h6 class="font-bold text-slate-700 mb-0">Edit Timetable Entry</h6>
                <p class="text-xs text-slate-400 mt-0.5">Update timetable information</p>
            </div>
        </div>

        <form method="POST" action="{{ route('tenant.timetable.update', [$subdomain, $timetable->id]) }}" class="p-6">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-xs font-semibold text-slate-600 mb-1.5">Class <span class="text-red-500">*</span></label>
                    <select name="class_id" required class="text-sm w-full rounded-lg border border-gray-300 bg-white py-2.5 px-3">
                        @foreach($classes as $class)
                            <option value="{{ $class->id }}" {{ $timetable->class_id == $class->id ? 'selected' : '' }}>{{ $class->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-600 mb-1.5">Subject <span class="text-red-500">*</span></label>
                    <select name="subject_id" required class="text-sm w-full rounded-lg border border-gray-300 bg-white py-2.5 px-3">
                        @foreach($subjects as $subject)
                            <option value="{{ $subject->id }}" {{ $timetable->subject_id == $subject->id ? 'selected' : '' }}>{{ $subject->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-600 mb-1.5">Teacher <span class="text-red-500">*</span></label>
                    <select name="teacher_id" required class="text-sm w-full rounded-lg border border-gray-300 bg-white py-2.5 px-3">
                        @foreach($teachers as $teacher)
                            <option value="{{ $teacher->id }}" {{ $timetable->teacher_id == $teacher->id ? 'selected' : '' }}>{{ $teacher->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-600 mb-1.5">Day <span class="text-red-500">*</span></label>
                    <select name="day" required class="text-sm w-full rounded-lg border border-gray-300 bg-white py-2.5 px-3">
                        <option value="Monday" {{ $timetable->day == 'Monday' ? 'selected' : '' }}>Monday</option>
                        <option value="Tuesday" {{ $timetable->day == 'Tuesday' ? 'selected' : '' }}>Tuesday</option>
                        <option value="Wednesday" {{ $timetable->day == 'Wednesday' ? 'selected' : '' }}>Wednesday</option>
                        <option value="Thursday" {{ $timetable->day == 'Thursday' ? 'selected' : '' }}>Thursday</option>
                        <option value="Friday" {{ $timetable->day == 'Friday' ? 'selected' : '' }}>Friday</option>
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-600 mb-1.5">Start Time <span class="text-red-500">*</span></label>
                    <input type="time" name="start_time" value="{{ $timetable->start_time }}" required class="text-sm w-full rounded-lg border border-gray-300 bg-white py-2.5 px-3">
                </div>

                <div>
    <label class="block text-xs font-semibold text-slate-600 mb-1.5">Term <span class="text-red-500">*</span></label>
    <select name="term" required class="text-sm w-full rounded-lg border border-gray-300 bg-white py-2.5 px-3">
        <option value="">-- Select Term --</option>
        <option value="1st" {{ $timetable->term == '1st' ? 'selected' : '' }}>1st Term/ 1st Semester</option>
        <option value="2nd" {{ $timetable->term == '2nd' ? 'selected' : '' }}>2nd Term/ 2nd Semester</option>
        <option value="3rd" {{ $timetable->term == '3rd' ? 'selected' : '' }}>3rd Term/ 3rd Semester</option>
    </select>
</div>

<div>
    <label class="block text-xs font-semibold text-slate-600 mb-1.5">Session <span class="text-red-500">*</span></label>
    <input type="text" name="session" value="{{ $timetable->session }}" placeholder="e.g. 2024/2025" required class="text-sm w-full rounded-lg border border-gray-300 bg-white py-2.5 px-3">
</div>

                <div>
                    <label class="block text-xs font-semibold text-slate-600 mb-1.5">End Time <span class="text-red-500">*</span></label>
                    <input type="time" name="end_time" value="{{ $timetable->end_time }}" required class="text-sm w-full rounded-lg border border-gray-300 bg-white py-2.5 px-3">
                </div>
            </div>

            <div class="flex items-center justify-end gap-3 mt-6 pt-4 border-t border-gray-100">
                <a href="{{ route('tenant.timetable.index', $subdomain) }}" class="px-6 py-2.5 text-sm font-semibold text-slate-600 border border-gray-300 rounded-lg hover:bg-gray-50">Cancel</a>
                <button type="submit" class="px-6 py-2.5 text-sm font-semibold text-white rounded-lg bg-gradient-to-tl from-blue-600 to-cyan-500">Update Entry</button>
            </div>
        </form>
    </div>

</div>

@endsection