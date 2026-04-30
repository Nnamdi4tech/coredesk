@extends('layouts.admin')

@section('content')

@php $subdomain = request()->route('subdomain'); @endphp

<div class="w-full px-6 py-6 mx-auto">
    
    {{-- PAGE HEADER --}}
    <div class="flex flex-wrap items-center justify-between mb-6 -mx-3">
        <div class="px-3">
            <h3 class="text-2xl font-bold text-slate-700 mb-1">My Profile</h3>
            <p class="text-sm text-slate-400">
                <i class="fa fa-home mr-1"></i> Dashboard
                <span class="mx-1 text-slate-300">/</span>
                <a href="{{ route('student.dashboard', $subdomain) }}" class="hover:text-slate-600">Student Portal</a>
                <span class="mx-1 text-slate-300">/</span>
                <span class="text-slate-600">My Profile</span>
            </p>
        </div>
        <div class="px-3 mt-3 md:mt-0">
            <a href="{{ route('student.dashboard', $subdomain) }}"
               class="px-4 py-2 text-sm border border-gray-300 rounded-lg text-slate-600 hover:bg-gray-50 transition-all">
                <i class="fa fa-arrow-left mr-1"></i> Back to Dashboard
            </a>
        </div>
    </div>

    {{-- Profile Card --}}
    <div class="bg-white shadow-soft-xl rounded-2xl overflow-hidden">
        
        <div class="bg-gradient-to-r from-purple-700 to-pink-500 px-6 py-6">
            <div class="flex items-center gap-4">
                <div class="w-20 h-20 rounded-2xl bg-white/20 backdrop-blur-sm flex items-center justify-center shadow-soft-lg">
                    <i class="fa fa-user-graduate text-white text-3xl"></i>
                </div>
                <div>
                    <h4 class="text-xl font-bold text-white mb-1">{{ $student->name }}</h4>
                    <p class="text-blue-100 text-sm text-white">{{ $student->student_id }}</p>
                </div>
            </div>
        </div>

        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                
                {{-- Personal Information --}}
                <div>
                    <div class="flex items-center gap-2 mb-4 pb-2 border-b border-gray-200">
                        <div class="w-6 h-6 rounded-lg bg-gradient-to-tl from-blue-500 to-cyan-400 flex items-center justify-center">
                            <i class="fa fa-user text-white text-xs"></i>
                        </div>
                        <span class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Personal Information</span>
                    </div>
                    
                    <div class="space-y-3">
                        <div class="flex items-center p-3 bg-gray-50 rounded-lg">
                            <div class="w-8 text-slate-400">
                                <i class="fa fa-user text-sm"></i>
                            </div>
                            <div class="flex-1">
                                <p class="text-xs text-slate-400">Full Name</p>
                                <p class="text-sm font-semibold text-slate-700">{{ $student->name }}</p>
                            </div>
                        </div>
                        
                        <div class="flex items-center p-3 bg-gray-50 rounded-lg">
                            <div class="w-8 text-slate-400">
                                <i class="fa fa-venus-mars text-sm"></i>
                            </div>
                            <div class="flex-1">
                                <p class="text-xs text-slate-400">Gender</p>
                                <p class="text-sm font-semibold text-slate-700">{{ $student->gender ?? 'N/A' }}</p>
                            </div>
                        </div>
                        
                        <div class="flex items-center p-3 bg-gray-50 rounded-lg">
                            <div class="w-8 text-slate-400">
                                <i class="fa fa-phone text-sm"></i>
                            </div>
                            <div class="flex-1">
                                <p class="text-xs text-slate-400">Phone Number</p>
                                <p class="text-sm font-semibold text-slate-700">{{ $student->phone ?? 'N/A' }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Academic Information --}}
                <div>
                    <div class="flex items-center gap-2 mb-4 pb-2 border-b border-gray-200">
                        <div class="w-6 h-6 rounded-lg bg-gradient-to-tl from-purple-500 to-pink-400 flex items-center justify-center">
                            <i class="fa fa-graduation-cap text-white text-xs"></i>
                        </div>
                        <span class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Academic Information</span>
                    </div>
                    
                    <div class="space-y-3">
                        <div class="flex items-center p-3 bg-gray-50 rounded-lg">
                            <div class="w-8 text-slate-400">
                                <i class="fa fa-id-card text-sm"></i>
                            </div>
                            <div class="flex-1">
                                <p class="text-xs text-slate-400">Student ID</p>
                                <p class="text-sm font-semibold text-slate-700">{{ $student->student_id }}</p>
                            </div>
                        </div>
                        
                        <div class="flex items-center p-3 bg-gray-50 rounded-lg">
                            <div class="w-8 text-slate-400">
                                <i class="fa fa-chalkboard text-sm"></i>
                            </div>
                            <div class="flex-1">
                                <p class="text-xs text-slate-400">Class</p>
                                <p class="text-sm font-semibold text-slate-700">{{ $student->schoolClass->name ?? 'N/A' }}</p>
                            </div>
                        </div>
                        
                        <div class="flex items-center p-3 bg-gray-50 rounded-lg">
                            <div class="w-8 text-slate-400">
                                <i class="fa fa-envelope text-sm"></i>
                            </div>
                            <div class="flex-1">
                                <p class="text-xs text-slate-400">Email Address</p>
                                <p class="text-sm font-semibold text-slate-700">{{ $student->email ?? 'N/A' }}</p>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>

    </div>

    {{-- Footer Note --}}
    <div class="mt-5 p-4 bg-gradient-to-r from-blue-50 to-cyan-50 rounded-xl border border-blue-100">
        <div class="flex items-start gap-3">
            <div class="w-8 h-8 rounded-lg bg-gradient-to-tl from-blue-500 to-cyan-400 flex items-center justify-center flex-shrink-0 shadow-soft-sm">
                <i class="fa fa-info-circle text-black text-xs"></i>
            </div>
            <div>
                <p class="text-sm font-semibold text-blue-800">Profile Information</p>
                <p class="text-xs text-blue-600 mt-0.5">
                    For any corrections or updates to your profile information, please contact the school administration.
                </p>
            </div>
        </div>
    </div>

</div>

@endsection