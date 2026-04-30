@extends('layouts.admin')

@section('content')

@php $subdomain = request()->route('subdomain'); @endphp

<div class="w-full px-6 py-6 mx-auto">

    {{-- PAGE HEADER --}}
    <div class="flex flex-wrap items-center justify-between mb-6 -mx-3">
        <div class="px-3">
            <h3 class="text-2xl font-bold text-slate-700 mb-1">Edit Result</h3>
            <p class="text-sm text-slate-400">
                <i class="fa fa-home mr-1"></i> Dashboard
                <span class="mx-1 text-slate-300">/</span>
                <a href="{{ route('tenant.teacher.results.index', $subdomain) }}" class="hover:text-slate-600">Results</a>
                <span class="mx-1 text-slate-300">/</span>
                <span class="text-slate-600">Edit Result</span>
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

    @php $isSubmitted = $result && $result->submitted; @endphp

    {{-- Locked banner --}}
    @if($isSubmitted)
        <div class="p-4 mb-5 text-sm text-red-700 bg-red-50 border border-red-200 rounded-2xl flex items-center gap-3">
            <div class="w-8 h-8 rounded-lg bg-gradient-to-tl from-red-500 to-rose-400 flex items-center justify-center flex-shrink-0">
                <i class="fa fa-lock text-white text-xs"></i>
            </div>
            <div>
                <p class="font-semibold">Result Locked</p>
                <p class="text-red-500 text-xs mt-0.5">This result has been submitted and cannot be edited.</p>
            </div>
        </div>
    @endif

    <div class="bg-white shadow-soft-xl rounded-2xl overflow-hidden">

        {{-- Card Header --}}
        <div class="flex items-center gap-3 px-6 py-4 border-b border-gray-100">
            <div class="w-8 h-8 rounded-lg bg-gradient-to-tl from-blue-500 to-cyan-400 flex items-center justify-center shadow-soft-md">
                <i class="fa fa-edit text-black text-xs"></i>
            </div>
            <div>
                <h6 class="font-bold text-slate-700 mb-0">{{ $student->name }}</h6>
                <p class="text-xs text-slate-400">
                    {{ $subject->name ?? 'N/A' }}
                    &mdash; {{ $result->term ?? request('term') }}
                    &mdash; {{ $result->session ?? request('session') }}
                </p>
            </div>
        </div>

        <form method="POST"
              action="{{ route('tenant.teacher.results.update', [$subdomain, $student->id]) }}"
              class="p-6">
            @csrf

            {{-- Pass everything the controller needs --}}
            <input type="hidden" name="subject_id" value="{{ $result->subject_id ?? request('subject_id') }}">
            <input type="hidden" name="term"       value="{{ $result->term ?? request('term') }}">
            <input type="hidden" name="session"    value="{{ $result->session ?? request('session') }}">

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                {{-- CA1 --}}
                <div>
                    <label class="block text-xs font-semibold text-slate-600 mb-1.5">
                        CA1 <span class="text-slate-400 font-normal">/20</span>
                    </label>
                    <input type="number" name="ca1"
                           value="{{ old('ca1', $result->ca1 ?? '') }}"
                           min="0" max="20" step="0.01"
                           {{ $isSubmitted ? 'disabled' : '' }}
                           class="w-full text-sm rounded-lg border border-gray-200 py-2.5 px-3 focus:outline-none focus:border-fuchsia-300 transition-all {{ $isSubmitted ? 'bg-gray-50 text-gray-400 cursor-not-allowed' : 'bg-white' }}">
                </div>

                {{-- CA2 --}}
                <div>
                    <label class="block text-xs font-semibold text-slate-600 mb-1.5">
                        CA2 <span class="text-slate-400 font-normal">/20</span>
                    </label>
                    <input type="number" name="ca2"
                           value="{{ old('ca2', $result->ca2 ?? '') }}"
                           min="0" max="20" step="0.01"
                           {{ $isSubmitted ? 'disabled' : '' }}
                           class="w-full text-sm rounded-lg border border-gray-200 py-2.5 px-3 focus:outline-none focus:border-fuchsia-300 transition-all {{ $isSubmitted ? 'bg-gray-50 text-gray-400 cursor-not-allowed' : 'bg-white' }}">
                </div>

                {{-- CA3 --}}
                <!-- <div>
                    <label class="block text-xs font-semibold text-slate-600 mb-1.5">
                        CA3 <span class="text-slate-400 font-normal">/40</span>
                    </label>
                    <input type="number" name="ca3"
                           value="{{ old('ca3', $result->ca3 ?? '') }}"
                           min="0" max="40" step="0.01"
                           {{ $isSubmitted ? 'disabled' : '' }}
                           class="w-full text-sm rounded-lg border border-gray-200 py-2.5 px-3 focus:outline-none focus:border-fuchsia-300 transition-all {{ $isSubmitted ? 'bg-gray-50 text-gray-400 cursor-not-allowed' : 'bg-white' }}">
                </div> -->

                {{-- Exam --}}
                <div>
                    <label class="block text-xs font-semibold text-slate-600 mb-1.5">
                        Exam <span class="text-slate-400 font-normal">/60</span>
                    </label>
                    <input type="number" name="exam"
                           value="{{ old('exam', $result->exam ?? '') }}"
                           min="0" max="60" step="0.01"
                           {{ $isSubmitted ? 'disabled' : '' }}
                           class="w-full text-sm rounded-lg border border-gray-200 py-2.5 px-3 focus:outline-none focus:border-fuchsia-300 transition-all {{ $isSubmitted ? 'bg-gray-50 text-gray-400 cursor-not-allowed' : 'bg-white' }}">
                </div>

            </div>

            {{-- Form Actions --}}
            @if(!$isSubmitted)
            <div class="flex items-center justify-between gap-3 mt-6 pt-4 border-t border-gray-100">

                {{-- Submit/Lock button --}}
                <button type="button"
                        onclick="if(confirm('⚠️ Results cannot be edited once submitted. Are you sure?')) { document.getElementById('submit-result-form').submit(); }"
                        class="px-5 py-2.5 text-sm font-semibold text-white rounded-lg bg-gradient-to-tl from-green-600 to-emerald-400 shadow-soft-md hover:shadow-soft-xl hover:scale-105 transition-all">
                    <i class="fa fa-check-circle mr-1"></i> Submit Result
                </button>

                <div class="flex gap-3">
                    <a href="{{ route('tenant.teacher.results.index', $subdomain) }}"
                       class="px-6 py-2.5 text-sm font-semibold text-slate-600 border border-gray-300 rounded-lg hover:bg-gray-50 transition-all">
                        <i class="fa fa-times mr-1"></i> Cancel
                    </a>
                    <button type="submit"
                            class="px-6 py-2.5 text-sm font-semibold text-white rounded-lg bg-gradient-to-tl from-blue-600 to-cyan-500 shadow-soft-md hover:shadow-soft-xl hover:scale-105 transition-all">
                        <i class="fa fa-save mr-1"></i> Save Result
                    </button>
                </div>
            </div>
            @endif

        </form>

        {{-- Hidden submit form --}}
        @if(!$isSubmitted)
        <form id="submit-result-form" method="POST"
              action="{{ route('tenant.teacher.results.submit', [$subdomain, $result->subject_id ?? request('subject_id')]) }}">
            @csrf
            <input type="hidden" name="term"    value="{{ $result->term ?? request('term') }}">
            <input type="hidden" name="session" value="{{ $result->session ?? request('session') }}">
        </form>
        @endif

    </div>

</div>

@endsection