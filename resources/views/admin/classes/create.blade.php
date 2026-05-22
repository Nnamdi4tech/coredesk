@extends('layouts.admin')

@section('content')

@php $subdomain = request()->route('subdomain'); @endphp

<div class="w-full px-6 py-6 mx-auto">

    {{-- PAGE HEADER --}}
    <div class="flex items-center justify-between mb-6">
        <div>
            <h3 class="text-xl font-bold text-slate-700 mb-1">Add New Class</h3>
            <p class="text-sm text-slate-400">
                <i class="fa fa-home mr-1"></i> Dashboard
                <span class="mx-1 text-slate-300">/</span>
                <a href="{{ route('tenant.classes.index', $subdomain) }}" class="hover:text-slate-600">Classes</a>
                <span class="mx-1 text-slate-300">/</span>
                <span class="text-slate-600">Add New</span>
            </p>
        </div>
        <a href="{{ route('tenant.classes.index', $subdomain) }}"
           class="px-4 py-2 text-sm border border-gray-300 rounded-lg text-slate-600 hover:bg-gray-50 transition-all">
            <i class="fa fa-arrow-left mr-1"></i> Back
        </a>
    </div>

    {{-- VALIDATION ERRORS --}}
    @if($errors->any())
        <div class="p-4 mb-6 text-sm text-red-700 bg-red-50 border border-red-200 rounded-2xl flex items-start gap-3">
            <div class="w-8 h-8 rounded-lg bg-gradient-to-tl from-red-500 to-rose-400 flex items-center justify-center flex-shrink-0 mt-0.5">
                <i class="fa fa-exclamation-circle text-white text-xs"></i>
            </div>
            <div>
                <p class="font-semibold mb-1">Please fix the following:</p>
                <ul class="list-disc list-inside space-y-0.5">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif

    {{-- SUCCESS MESSAGE --}}
    @if(session('success'))
        <div class="p-4 mb-6 text-sm text-green-700 bg-green-50 border border-green-200 rounded-2xl flex items-center gap-3">
            <div class="w-8 h-8 rounded-lg bg-gradient-to-tl from-green-500 to-emerald-400 flex items-center justify-center flex-shrink-0">
                <i class="fa fa-check text-white text-xs"></i>
            </div>
            <div>
                <p class="font-semibold">Class Added Successfully!</p>
                <p class="text-green-600 text-xs mt-0.5">{{ session('success') }}</p>
            </div>
            <button onclick="this.parentElement.remove()" class="ml-auto text-green-400 hover:text-green-600">
                <i class="fa fa-times text-xs"></i>
            </button>
        </div>
    @endif

    <form method="POST" action="{{ route('tenant.classes.store', $subdomain) }}">
        @csrf

        <div class="bg-white shadow-soft-xl rounded-2xl p-6 mb-5">
            <div class="flex items-center gap-3 mb-5 pb-4 border-b border-gray-100">
                <div class="w-8 h-8 rounded-lg bg-gradient-to-tl from-purple-500 to-fuchsia-400 flex items-center justify-center shadow-soft-md">
                    <i class="fa fa-chalkboard text-black text-xs"></i>
                </div>
                <div>
                    <h6 class="font-bold text-slate-700 mb-0">Class Information</h6>
                    <p class="text-xs text-slate-400">Enter the class name e.g. JSS1B, SS2C, JSS2A, Basic4A</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

                {{-- Class Name --}}
                <div>
                    <label class="block text-xs font-semibold text-slate-600 mb-1.5">
                        Class Name <span class="text-red-500">*</span>
                    </label>
                    <input type="text"
                           name="name"
                           value="{{ old('name') }}"
                           placeholder="e.g. JSS1A, SS2B, JSS2C"
                           class="text-sm w-full rounded-lg border border-gray-300 bg-white py-2 px-3 text-gray-700 focus:outline-none focus:border-fuchsia-300 transition-all @error('name') border-red-400 @enderror"
                           required />
                    @error('name')
                        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

            </div>
        </div>

        {{-- FORM ACTIONS --}}
        <div class="flex items-center justify-between">
            <a href="{{ route('tenant.classes.index', $subdomain) }}"
               class="px-6 py-2.5 text-sm border border-gray-300 rounded-lg text-slate-600 hover:bg-gray-50 transition-all">
                <i class="fa fa-times mr-1"></i> Cancel
            </a>
            <button type="submit"
                    class="px-8 py-2.5 text-sm font-semibold text-white rounded-lg bg-gradient-to-tl from-gray-900 to-slate-700 shadow-soft-md hover:shadow-soft-xl hover:scale-105 transition-all">
                <i class="fa fa-save mr-1"></i> Save Class
            </button>
        </div>

    </form>

</div>

@endsection