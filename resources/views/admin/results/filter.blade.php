@extends('layouts.admin')

@section('content')

@php $subdomain = request()->route('subdomain'); @endphp

<div class="w-full px-6 py-6 mx-auto">

    {{-- PAGE HEADER --}}
    <div class="flex flex-wrap items-center justify-between mb-6 -mx-3">
        <div class="px-3">
            <h3 class="text-2xl font-bold text-slate-700 mb-1">Generate Report Card</h3>
            <p class="text-sm text-slate-400">
                <i class="fa fa-home mr-1"></i> Dashboard
                <span class="mx-1 text-slate-300">/</span>
                <span class="text-slate-600">Report Card Generator</span>
            </p>
        </div>
        <div class="px-3 mt-3 md:mt-0">
            <a href="{{ route('tenant.admin.dashboard', $subdomain) }}"
               class="px-4 py-2 text-sm border border-gray-300 rounded-lg text-slate-600 hover:bg-gray-50 transition-all">
                <i class="fa fa-arrow-left mr-1"></i> Back to Dashboard
            </a>
        </div>
    </div>

    {{-- INFO CARD --}}
    <div class="mb-6 p-4 bg-gradient-to-r from-blue-50 to-cyan-50 rounded-xl border border-blue-100">
        <div class="flex items-start gap-3">
            <div class="w-8 h-8 rounded-lg bg-gradient-to-tl from-blue-500 to-cyan-400 flex items-center justify-center flex-shrink-0 shadow-soft-sm">
                <i class="fa fa-info-circle text-primary text-xs"></i>
            </div>
            <div>
                <p class="text-sm font-semibold text-blue-800">Generate Student Report Card</p>
                <p class="text-xs text-blue-600 mt-0.5">
                    Select the student, class, term, and session to generate a comprehensive report card showing all subjects, scores, grades, and class position.
                </p>
            </div>
        </div>
    </div>

    {{-- FILTER FORM CARD --}}
    <div class="bg-white shadow-soft-xl rounded-2xl overflow-hidden">
        <div class="flex items-center gap-3 px-6 py-4 border-b border-gray-100">
            <div class="w-8 h-8 rounded-lg bg-gradient-to-tl from-purple-500 to-pink-400 flex items-center justify-center shadow-soft-md">
                <i class="fa fa-file-alt text-primary text-xs"></i>
            </div>
            <div>
                <h6 class="font-bold text-slate-700 mb-0">Select Report Criteria</h6>
                <p class="text-xs text-slate-400 mt-0.5">Choose the parameters to generate the report card</p>
            </div>
        </div>

        <form method="GET" action="{{ route('tenant.admin.results.student', $subdomain) }}" class="p-6">
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                {{-- Session Selection --}}
<div>
    <label class="block text-xs font-semibold text-slate-600 mb-1.5">
        <i class="fa fa-calendar-week mr-1 text-slate-400"></i> Academic Session
    </label>
    <select name="session"
            required
            class="text-sm w-full rounded-lg border border-gray-300 bg-white py-2.5 px-3 text-gray-700 focus:outline-none focus:border-fuchsia-300 focus:ring-1 focus:ring-fuchsia-200 transition-all">
        <option value="">-- Select Session --</option>
        @foreach($sessions as $session)
            <option value="{{ $session }}" {{ request('session') == $session ? 'selected' : '' }}>
                {{ $session }}
            </option>
        @endforeach
    </select>
</div>

{{-- Class Selection --}}
                <div>
                    <label class="block text-xs font-semibold text-slate-600 mb-1.5">
                        <i class="fa fa-chalkboard mr-1 text-slate-400"></i> Class
                    </label>
                    <select name="class_id" 
                            required
                            class="text-sm w-full rounded-lg border border-gray-300 bg-white py-2.5 px-3 text-gray-700 focus:outline-none focus:border-fuchsia-300 focus:ring-1 focus:ring-fuchsia-200 transition-all">
                        <option value="">-- Select Class --</option>
                        @foreach($classes as $class)
                            <option value="{{ $class->id }}" {{ request('class_id') == $class->id ? 'selected' : '' }}>
                                {{ $class->name }}
                            </option>
                        @endforeach
                    </select>
                    @if($classes->isEmpty())
                        <p class="text-xs text-amber-500 mt-2">
                            <i class="fa fa-exclamation-triangle mr-1"></i>
                            No classes available.
                        </p>
                    @endif
                </div>

                {{-- Term Selection --}}
<div>
    <label class="block text-xs font-semibold text-slate-600 mb-1.5">
        <i class="fa fa-calendar-alt mr-1 text-slate-400"></i> Term/Semester
    </label>
    <select name="term"
            required
            class="text-sm w-full rounded-lg border border-gray-300 bg-white py-2.5 px-3 text-gray-700 focus:outline-none focus:border-fuchsia-300 focus:ring-1 focus:ring-fuchsia-200 transition-all">
        <option value="">-- Select Term --</option>
        @foreach($terms as $term)
            <option value="{{ $term }}" {{ request('term') == $term ? 'selected' : '' }}>
                {{ $term }}
            </option>
        @endforeach
    </select>
</div>


                {{-- Student Selection --}}
<div>
    <label class="block text-xs font-semibold text-slate-600 mb-1.5">
        <i class="fa fa-user-graduate mr-1 text-slate-400"></i> Student <span class="text-red-500">*</span>
    </label>
    <select name="student_id" 
            id="studentSelect"
           
            class="text-sm w-full rounded-lg border border-gray-300 bg-white py-2.5 px-3 text-gray-700 focus:outline-none focus:border-fuchsia-300 focus:ring-1 focus:ring-fuchsia-200 transition-all">
        <option value="">-- Select Student --</option>
        @foreach($students as $student)
            <option value="{{ $student->id }}" {{ request('student_id') == $student->id ? 'selected' : '' }}>
                {{ $student->name }} ({{ $student->student_id ?? 'N/A' }})
            </option>
        @endforeach
    </select>
    <p class="text-xs text-gray-500 mt-1">
        Select a student to generate an individual report card
    </p>
    @if($students->isEmpty())
        <p class="text-xs text-amber-500 mt-2">
            <i class="fa fa-exclamation-triangle mr-1"></i>
            No students available.
        </p>
    @endif
</div>

                
            </div>

            {{-- Quick Tips --}}
            <div class="mt-6 p-3 bg-gray-50 rounded-lg border border-gray-200">
                <div class="flex items-start gap-2">
                    <i class="fa fa-lightbulb text-amber-500 text-sm mt-0.5"></i>
                    <div>
                        <p class="text-xs font-semibold text-slate-600">Quick Tips:</p>
                        <ul class="text-xs text-slate-500 mt-1 space-y-1 list-disc list-inside">
                            <li>Select all fields to generate a complete report card for a student</li>
                            <li>Do not select a student if you want to view all class report card</li>
                            <li>The report includes all subjects for the selected student/students in that class</li>
                            <li>Class position is calculated based on overall performance</li>
                            <li>You can print the report card after generation</li>
                        </ul>
                    </div>
                </div>
            </div>

            {{-- Form Actions --}}
<div class="flex items-center justify-end gap-3 mt-6 pt-4 border-t border-gray-100">

    <a href="{{ route('tenant.admin.dashboard', $subdomain) }}"
       class="px-6 py-2.5 text-sm font-semibold text-slate-600 border border-gray-300 rounded-lg hover:bg-gray-50 transition-all">
        <i class="fa fa-times mr-1"></i> Cancel
    </a>

    {{-- View Class Result --}}
    <button type="submit"
            formaction="{{ route('tenant.admin.results.class', $subdomain) }}"
            class="px-6 py-2.5 text-sm font-semibold text-black rounded-lg bg-gradient-to-tl from-purple-600 to-pink-500 shadow-soft-md hover:shadow-soft-xl hover:scale-105 transition-all">
        <i class="fa fa-users mr-1 text-black"></i> View Class Result
    </button>

    {{-- Generate Report Card --}}
    <button type="submit"
            id="generateReportBtn"
            disabled
            class="px-6 py-2.5 text-sm font-semibold text-black rounded-lg bg-gradient-to-tl from-blue-600 to-cyan-500 shadow-soft-md hover:shadow-soft-xl hover:scale-105 transition-all opacity-50 cursor-not-allowed">
        <i class="fa fa-download mr-1"></i> Generate Student Report Card
    </button>

</div>

            

        </form>
    </div>

    

    {{-- Additional Information Card --}}
    <div class="mt-5 p-4 bg-white shadow-soft-sm rounded-xl border border-gray-100">
        <div class="flex items-center gap-2 mb-3">
            <i class="fa fa-chart-line text-blue-500 text-sm"></i>
            <span class="text-xs font-semibold text-slate-600 uppercase tracking-wider">Report Card Preview</span>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-center">
            <div class="p-3 bg-gray-50 rounded-lg">
                <i class="fa fa-user-graduate text-slate-400 text-lg mb-1"></i>
                <p class="text-xs text-slate-500">Student Information</p>
                <p class="text-sm font-semibold text-slate-700">Name, ID, Class</p>
            </div>
            <div class="p-3 bg-gray-50 rounded-lg">
                <i class="fa fa-book-open text-slate-400 text-lg mb-1"></i>
                <p class="text-xs text-slate-500">Subject Performance</p>
                <p class="text-sm font-semibold text-slate-700">CA1, CA2, CA3, Exam</p>
            </div>
            <div class="p-3 bg-gray-50 rounded-lg">
                <i class="fa fa-trophy text-slate-400 text-lg mb-1"></i>
                <p class="text-xs text-slate-500">Overall Standing</p>
                <p class="text-sm font-semibold text-slate-700">Total, Average, Position</p>
            </div>
        </div>
    </div>

</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const studentSelect = document.getElementById('studentSelect');
        const generateBtn = document.getElementById('generateReportBtn');
        
        function toggleGenerateButton() {
            if (studentSelect && studentSelect.value) {
                generateBtn.disabled = false;
                generateBtn.classList.remove('opacity-50', 'cursor-not-allowed');
                generateBtn.classList.add('hover:scale-105');
            } else {
                generateBtn.disabled = true;
                generateBtn.classList.add('opacity-50', 'cursor-not-allowed');
                generateBtn.classList.remove('hover:scale-105');
            }
        }
        
        // Initial check
        toggleGenerateButton();
        
        // Listen for changes
        if (studentSelect) {
            studentSelect.addEventListener('change', toggleGenerateButton);
        }
    });
</script>

@endsection