@extends('layouts.admin')

@section('content')

@php $subdomain = request()->route('subdomain'); @endphp

<div class="w-full px-6 py-6 mx-auto">

    {{-- PAGE HEADER --}}
    <div class="flex flex-wrap items-center justify-between mb-6 -mx-3">
        <div class="px-3">
            <h3 class="text-2xl font-bold text-slate-700 mb-1">Classes</h3>
            <p class="text-sm text-slate-400">
                <i class="fa fa-home mr-1"></i> Dashboard
                <span class="mx-1 text-slate-300">/</span>
                <span class="text-slate-600">Classes Management</span>
            </p>
        </div>
        <div class="px-3">
            <a href="{{ route('tenant.classes.create', $subdomain) }}"
               class="px-5 py-2 text-sm font-semibold text-white rounded-lg bg-gradient-to-tl from-gray-900 to-slate-700 shadow-soft-md hover:shadow-soft-xl hover:scale-105 transition-all">
                <i class="fa fa-plus mr-1"></i> Add New Class
            </a>
        </div>
    </div>

    {{-- STAT CARDS ROW 1 — 4 CARDS --}}
    <div class="flex flex-wrap -mx-3 mb-6">
        
        <!-- card1 - Total Classes -->
        <div class="w-full max-w-full px-3 mb-6 sm:w-1/2 sm:flex-none xl:mb-0 xl:w-1/4">
            <div class="relative flex flex-col min-w-0 break-words bg-white shadow-soft-xl rounded-2xl bg-clip-border">
                <div class="flex-auto p-4">
                    <div class="flex flex-row -mx-3">
                        <div class="flex-none w-2/3 max-w-full px-3">
                            <div>
                                <p class="mb-0 font-sans text-sm font-semibold leading-normal">Total Classes</p>
                                <h5 class="mb-0 font-bold">
                                    {{ $totalClasses }}
                                    <span class="text-sm leading-normal font-weight-bolder text-lime-500">classes</span>
                                </h5>
                            </div>
                        </div>
                        <div class="px-3 text-right basis-1/3">
                            <div class="inline-block w-12 h-12 text-center rounded-lg bg-gradient-to-tl from-purple-500 to-fuchsia-400">
                                <i class="fa fa-chalkboard text-lg relative top-3.5 text-primary"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- card2 - Total Students -->
        <div class="w-full max-w-full px-3 mb-6 sm:w-1/2 sm:flex-none xl:mb-0 xl:w-1/4">
            <div class="relative flex flex-col min-w-0 break-words bg-white shadow-soft-xl rounded-2xl bg-clip-border">
                <div class="flex-auto p-4">
                    <div class="flex flex-row -mx-3">
                        <div class="flex-none w-2/3 max-w-full px-3">
                            <div>
                                <p class="mb-0 font-sans text-sm font-semibold leading-normal">Total Students</p>
                                <h5 class="mb-0 font-bold">
                                    {{ $totalStudents }}
                                    <span class="text-sm leading-normal font-weight-bolder text-lime-500">enrolled</span>
                                </h5>
                            </div>
                        </div>
                        <div class="px-3 text-right basis-1/3">
                            <div class="inline-block w-12 h-12 text-center rounded-lg bg-gradient-to-tl from-blue-500 to-cyan-400">
                                <i class="fa fa-user-graduate text-lg relative top-3.5 text-primary"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- card3 - Total Subjects -->
        <div class="w-full max-w-full px-3 mb-6 sm:w-1/2 sm:flex-none xl:mb-0 xl:w-1/4">
            <div class="relative flex flex-col min-w-0 break-words bg-white shadow-soft-xl rounded-2xl bg-clip-border">
                <div class="flex-auto p-4">
                    <div class="flex flex-row -mx-3">
                        <div class="flex-none w-2/3 max-w-full px-3">
                            <div>
                                <p class="mb-0 font-sans text-sm font-semibold leading-normal">Total Subjects</p>
                                <h5 class="mb-0 font-bold">
                                    {{ $totalSubjects }}
                                    <span class="text-sm leading-normal font-weight-bolder text-purple-500">subjects</span>
                                </h5>
                            </div>
                        </div>
                        <div class="px-3 text-right basis-1/3">
                            <div class="inline-block w-12 h-12 text-center rounded-lg bg-gradient-to-tl from-green-500 to-emerald-400">
                                <i class="fa fa-book-open text-lg relative top-3.5 text-primary"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- card4 - Avg Students per Class -->
        <div class="w-full max-w-full px-3 sm:w-1/2 sm:flex-none xl:w-1/4">
            <div class="relative flex flex-col min-w-0 break-words bg-white shadow-soft-xl rounded-2xl bg-clip-border">
                <div class="flex-auto p-4">
                    <div class="flex flex-row -mx-3">
                        <div class="flex-none w-2/3 max-w-full px-3">
                            <div>
                                <p class="mb-0 font-sans text-sm font-semibold leading-normal">Avg Students/Class</p>
                                <h5 class="mb-0 font-bold">
                                    {{ $avgStudentsPerClass }}
                                    <span class="text-sm leading-normal font-weight-bolder text-orange-500">per class</span>
                                </h5>
                            </div>
                        </div>
                        <div class="px-3 text-right basis-1/3">
                            <div class="inline-block w-12 h-12 text-center rounded-lg bg-gradient-to-tl from-orange-500 to-yellow-400">
                                <i class="fa fa-chart-line text-lg relative top-3.5 text-primary"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    {{-- SUCCESS MESSAGE --}}
    @if(session('success'))
        <div class="p-4 mb-6 text-sm text-green-700 bg-green-50 border border-green-200 rounded-2xl flex items-center gap-3">
            <div class="w-8 h-8 rounded-lg bg-gradient-to-tl from-green-500 to-emerald-400 flex items-center justify-center flex-shrink-0">
                <i class="fa fa-check text-primary text-xs"></i>
            </div>
            <div>
                <p class="font-semibold">Success!</p>
                <p class="text-green-600 text-xs mt-0.5">{{ session('success') }}</p>
            </div>
            <button onclick="this.parentElement.remove()" class="ml-auto text-green-400 hover:text-green-600">
                <i class="fa fa-times text-xs"></i>
            </button>
        </div>
    @endif

    {{-- TABLE CARD --}}
    <div class="bg-white shadow-soft-xl rounded-2xl overflow-hidden">

        {{-- CARD HEADER --}}
        <div class="flex items-center gap-3 px-6 py-4 border-b border-gray-100">
            <div class="w-8 h-8 rounded-lg bg-gradient-to-tl from-purple-500 to-fuchsia-400 flex items-center justify-center shadow-soft-md">
                <i class="fa fa-chalkboard text-primary text-xs"></i>
            </div>
            <div>
                <h6 class="font-bold text-slate-700 mb-0">All Classes</h6>
                <p class="text-xs text-slate-400">{{ $classes->count() }} class{{ $classes->count() !== 1 ? 'es' : '' }} found</p>
            </div>
        </div>

        {{-- TABLE --}}
        @if($classes->isEmpty())
            <div class="flex flex-col items-center justify-center py-16 text-slate-400">
                <i class="fa fa-chalkboard text-4xl mb-3 text-slate-300"></i>
                <p class="text-sm font-semibold">No classes added yet</p>
                <p class="text-xs mt-1">Click "Add New Class" to get started.</p>
                <a href="{{ route('tenant.classes.create', $subdomain) }}"
                   class="mt-4 px-5 py-2 text-sm font-semibold text-primary rounded-lg bg-gradient-to-tl from-gray-900 to-slate-700 hover:scale-105 transition-all">
                    <i class="fa fa-plus mr-1"></i> Add Class
                </a>
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left">
                    <thead>
                        <tr class="bg-gray-50 text-xs font-semibold text-slate-500 uppercase tracking-wide">
                            <th class="px-6 py-3">#</th>
                            <th class="px-6 py-3">Class Name</th>
                            <th class="px-6 py-3">Students Count</th>
                            <th class="px-6 py-3">Subjects Assigned</th>
                            <th class="px-6 py-3">Date Added</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach($classes as $index => $class)
                            @php
                                $studentCount = \App\Models\Student::where('tenant_id', auth()->user()->tenant_id)
                                    ->where('class_id', $class->id)->count();
                                $subjectsCount = DB::table('teacher_subjects')
                                    ->where('tenant_id', auth()->user()->tenant_id)
                                    ->where('class_id', $class->id)
                                    ->distinct('subject_id')
                                    ->count('subject_id');
                            @endphp
                            <tr class="hover:bg-gray-50 transition-all">
                                <td class="px-6 py-4 text-slate-400 text-xs">{{ $index + 1 }}</td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-8 h-8 rounded-lg bg-gradient-to-tl from-purple-500 to-fuchsia-400 flex items-center justify-center shadow-soft-sm">
                                            <i class="fa fa-chalkboard text-primary text-xs"></i>
                                        </div>
                                        <span class="font-semibold text-slate-700">{{ $class->name }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="inline-flex items-center gap-1 text-sm font-semibold text-blue-600">
                                        <i class="fa fa-users text-xs"></i> {{ $studentCount }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="inline-flex items-center gap-1 text-sm font-semibold text-purple-600">
                                        <i class="fa fa-book-open text-xs"></i> {{ $subjectsCount }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-slate-400 text-xs">
                                    {{ $class->created_at->format('d M Y') }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif

    </div>

</div>

@endsection