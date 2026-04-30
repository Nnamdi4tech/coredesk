@extends('layouts.admin')

@section('content')

@php $subdomain = request()->route('subdomain'); @endphp

<div class="w-full px-6 py-6 mx-auto">

    {{-- PAGE HEADER --}}
    <div class="flex flex-wrap items-center justify-between mb-6 -mx-3">
        <div class="px-3">
            <h3 class="text-2xl font-bold text-slate-700 mb-1">Add Result</h3>
            <p class="text-sm text-slate-400">
                <i class="fa fa-home mr-1"></i> Dashboard
                <span class="mx-1 text-slate-300">/</span>
                <a href="{{ route('tenant.teacher.results.index', $subdomain) }}" class="hover:text-slate-600">Results</a>
                <span class="mx-1 text-slate-300">/</span>
                <span class="text-slate-600">Add Result</span>
            </p>
        </div>
        <div class="px-3 mt-3 md:mt-0">
            <a href="{{ route('tenant.teacher.results.index', $subdomain) }}"
               class="px-4 py-2 text-sm border border-gray-300 rounded-lg text-slate-600 hover:bg-gray-50 transition-all">
                <i class="fa fa-arrow-left mr-1"></i> Back to Results
            </a>
        </div>
    </div>

    {{-- SUCCESS / ERROR MESSAGES --}}
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

    {{-- ADD RESULT FORM CARD --}}
    <div class="bg-white shadow-soft-xl rounded-2xl overflow-hidden">
        <div class="flex items-center gap-3 px-6 py-4 border-b border-gray-100">
            <div class="w-8 h-8 rounded-lg bg-gradient-to-tl from-blue-500 to-cyan-400 flex items-center justify-center shadow-soft-md">
                <i class="fa fa-plus-circle text-white text-xs"></i>
            </div>
            <div>
                <h6 class="font-bold text-slate-700 mb-0">Result Information</h6>
                <p class="text-xs text-slate-400">Enter student result details</p>
            </div>
        </div>

        <form method="POST" action="{{ route('tenant.teacher.results.store', $subdomain) }}" class="p-6">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                {{-- Student Selection --}}
                <div>
                    <label class="block text-xs font-semibold text-slate-600 mb-1.5">
                        <i class="fa fa-user-graduate mr-1 text-slate-400"></i> Student
                    </label>
                    <select name="student_id" 
                            required
                            class="text-sm w-full rounded-lg border border-gray-300 bg-white py-2.5 px-3 text-gray-700 focus:outline-none focus:border-fuchsia-300 focus:ring-1 focus:ring-fuchsia-200 transition-all">
                        <option value="">-- Select Student --</option>
                        @foreach($students as $student)
                            <option value="{{ $student->id }}" {{ old('student_id') == $student->id ? 'selected' : '' }}>
                                {{ $student->name }} ({{ $student->student_id ?? 'N/A' }})
                            </option>
                        @endforeach
                    </select>
                    @if($students->isEmpty())
                        <p class="text-xs text-amber-500 mt-2">
                            <i class="fa fa-exclamation-triangle mr-1"></i>
                            No students available.
                        </p>
                    @endif
                </div>

                {{-- Subject Selection --}}
                <div>
                    <label class="block text-xs font-semibold text-slate-600 mb-1.5">
                        <i class="fa fa-book-open mr-1 text-slate-400"></i> Subject
                    </label>
                    <select name="subject_id" 
                            required
                            class="text-sm w-full rounded-lg border border-gray-300 bg-white py-2.5 px-3 text-gray-700 focus:outline-none focus:border-fuchsia-300 focus:ring-1 focus:ring-fuchsia-200 transition-all">
                        <option value="">-- Select Subject --</option>
                        @foreach($subjects as $subject)
                            <option value="{{ $subject->id }}" {{ old('subject_id') == $subject->id ? 'selected' : '' }}>
                                {{ $subject->name }}
                            </option>
                        @endforeach
                    </select>
                    @if($subjects->isEmpty())
                        <p class="text-xs text-amber-500 mt-2">
                            <i class="fa fa-exclamation-triangle mr-1"></i>
                            No subjects assigned to you.
                        </p>
                    @endif
                </div>

                {{-- CA1 --}}
                <div>
                    <label class="block text-xs font-semibold text-slate-600 mb-1.5">
                        <i class="fa fa-chart-line mr-1 text-slate-400"></i> CA1 <span class="text-slate-400 font-normal">/20</span>
                    </label>
                    <input type="number" 
                           name="ca1" 
                           value="{{ old('ca1') }}"
                           min="0" 
                           max="20"
                           step="0.01"
                           class="w-full text-sm rounded-lg border border-gray-200 py-2.5 px-3 focus:outline-none focus:border-fuchsia-300 focus:ring-1 focus:ring-fuchsia-200 transition-all bg-white" 
                           placeholder="Enter CA1 score (0-20)">
                </div>

                {{-- CA2 --}}
                <div>
                    <label class="block text-xs font-semibold text-slate-600 mb-1.5">
                        <i class="fa fa-chart-line mr-1 text-slate-400"></i> CA2 <span class="text-slate-400 font-normal">/20</span>
                    </label>
                    <input type="number" 
                           name="ca2" 
                           value="{{ old('ca2') }}"
                           min="0" 
                           max="20"
                           step="0.01"
                           class="w-full text-sm rounded-lg border border-gray-200 py-2.5 px-3 focus:outline-none focus:border-fuchsia-300 focus:ring-1 focus:ring-fuchsia-200 transition-all bg-white" 
                           placeholder="Enter CA2 score (0-20)">
                </div>

                <!-- {{-- CA3 --}}
                <div>
                    <label class="block text-xs font-semibold text-slate-600 mb-1.5">
                        <i class="fa fa-chart-line mr-1 text-slate-400"></i> CA3 <span class="text-slate-400 font-normal">/40</span>
                    </label>
                    <input type="number" 
                           name="ca3" 
                           value="{{ old('ca3') }}"
                           min="0" 
                           max="40"
                           step="0.01"
                           class="w-full text-sm rounded-lg border border-gray-200 py-2.5 px-3 focus:outline-none focus:border-fuchsia-300 focus:ring-1 focus:ring-fuchsia-200 transition-all bg-white" 
                           placeholder="Enter CA3 score (0-40)">
                </div> -->

                {{-- Exam --}}
                <div>
                    <label class="block text-xs font-semibold text-slate-600 mb-1.5">
                        <i class="fa fa-pen-alt mr-1 text-slate-400"></i> Exam <span class="text-slate-400 font-normal">/60</span>
                    </label>
                    <input type="number" 
                           name="exam" 
                           value="{{ old('exam') }}"
                           min="0" 
                           max="60"
                           step="0.01"
                           class="w-full text-sm rounded-lg border border-gray-200 py-2.5 px-3 focus:outline-none focus:border-fuchsia-300 focus:ring-1 focus:ring-fuchsia-200 transition-all bg-white" 
                           placeholder="Enter Exam score (0-60)">
                </div>

                {{-- Term --}}
<div>
    <label class="block text-xs font-semibold text-slate-600 mb-1.5">
        <i class="fa fa-calendar-alt mr-1 text-slate-400"></i> Term / Semester
    </label>
    <select name="term" required
        class="text-sm w-full rounded-lg border border-gray-300 bg-white py-2.5 px-3 text-gray-700 focus:outline-none focus:border-fuchsia-300 focus:ring-1 focus:ring-fuchsia-200 transition-all">
        <option value="">-- Select Term --</option>
        @foreach($terms as $term)
            <option value="{{ $term }}">{{ $term }}</option>
        @endforeach
    </select>
</div>

{{-- Session --}}
<div>
    <label class="block text-xs font-semibold text-slate-600 mb-1.5">
        <i class="fa fa-calendar mr-1 text-slate-400"></i> Session
    </label>
    <select name="session" required
        class="text-sm w-full rounded-lg border border-gray-300 bg-white py-2.5 px-3 text-gray-700 focus:outline-none focus:border-fuchsia-300 focus:ring-1 focus:ring-fuchsia-200 transition-all">
        <option value="">-- Select Session --</option>
        @foreach($sessions as $session)
            <option value="{{ $session }}" 
               {{ $loop->first ? 'selected' : '' }}>
               {{ $session }}
            </option>
        @endforeach
    </select>
</div>
            </div>

            {{-- Score Summary --}}
            <div class="mt-6 p-4 bg-gradient-to-r from-blue-50 to-cyan-50 rounded-xl border border-blue-100">
                <div class="flex items-center gap-2 mb-2">
                    <i class="fa fa-calculator text-blue-500 text-sm"></i>
                    <span class="text-xs font-semibold text-blue-700 uppercase tracking-wider">Score Summary</span>
                </div>
                <p class="text-sm text-slate-600">
                    Total Score = CA1 + CA2  + Exam (Max: 100)
                </p>
                <p class="text-xs text-slate-500 mt-1">
                    <i class="fa fa-info-circle mr-1"></i>
                    Final grade will be calculated automatically based on total score.
                </p>
            </div>

            {{-- Form Actions --}}
            <div class="flex items-center justify-end gap-3 mt-6 pt-4 border-t border-gray-100">
                <a href="{{ route('tenant.teacher.results.index', $subdomain) }}"
                   class="px-6 py-2.5 text-sm font-semibold text-slate-600 border border-gray-300 rounded-lg hover:bg-gray-50 transition-all">
                    <i class="fa fa-times mr-1"></i> Cancel
                </a>
                <button type="submit"
                        class="px-6 py-2.5 text-sm font-semibold text-white rounded-lg bg-gradient-to-tl from-blue-600 to-cyan-500 shadow-soft-md hover:shadow-soft-xl hover:scale-105 transition-all">
                    <i class="fa fa-save mr-1"></i> Save Result
                </button>
            </div>
        </form>
    </div>

</div>

@endsection