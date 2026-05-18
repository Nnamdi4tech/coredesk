@extends('layouts.admin')

@section('content')

@php 
    $subdomain = request()->route('subdomain'); 
    
    // Auto-generate Student ID
    $lastStudent = \App\Models\Student::where('tenant_id', auth()->user()->tenant_id)->latest()->first();
    if ($lastStudent && $lastStudent->student_id) {
        $lastNumber = (int) substr($lastStudent->student_id, -4);
        $newNumber = str_pad($lastNumber + 1, 4, '0', STR_PAD_LEFT);
        $generatedStudentId = 'ST-ID-' . date('Y') . '-' . $newNumber;
    } else {
        $generatedStudentId = 'ST-ID-' . date('Y') . '-0001';
    }
@endphp

<div class="w-full px-6 py-6 mx-auto">

    {{-- PAGE HEADER --}}
    <div class="flex items-center justify-between mb-6">
        <div>
            <h3 class="text-xl font-bold text-slate-700 mb-1">Add New Student</h3>
            <p class="text-sm text-slate-400">
                <i class="fa fa-home mr-1"></i> Dashboard
                <span class="mx-1 text-slate-300">/</span>
                <a href="{{ route('tenant.students.index', $subdomain) }}" class="hover:text-slate-600">Students</a>
                <span class="mx-1 text-slate-300">/</span>
                <span class="text-slate-600">Add New</span>
            </p>
        </div>
        <a href="{{ route('tenant.students.index', $subdomain) }}"
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

    {{-- Plan limit error --}}
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

    

    {{-- SUCCESS MESSAGE --}}
    @if(session('success'))
        <div class="p-4 mb-6 text-sm text-green-700 bg-green-50 border border-green-200 rounded-2xl flex items-center gap-3">
            <div class="w-8 h-8 rounded-lg bg-gradient-to-tl from-green-500 to-emerald-400 flex items-center justify-center flex-shrink-0">
                <i class="fa fa-check text-white text-xs"></i>
            </div>
            <div>
                <p class="font-semibold">Student Added Successfully!</p>
                <p class="text-green-600 text-xs mt-0.5">{{ session('success') }}</p>
            </div>
            <button onclick="this.parentElement.remove()" class="ml-auto text-green-400 hover:text-green-600">
                <i class="fa fa-times text-xs"></i>
            </button>
        </div>
    @endif

    <form method="POST" action="{{ route('tenant.students.store', $subdomain) }}">
        @csrf

        {{-- SECTION 1: PERSONAL INFO --}}
        <div class="bg-white shadow-soft-xl rounded-2xl p-6 mb-5">
            <div class="flex items-center gap-3 mb-5 pb-4 border-b border-gray-100">
                <div class="w-8 h-8 rounded-lg bg-gradient-to-tl from-blue-500 to-cyan-400 flex items-center justify-center shadow-soft-md">
                    <i class="fa fa-user-graduate text-black text-xs"></i>
                </div>
                <div>
                    <h6 class="font-bold text-slate-700 mb-0">Personal Information</h6>
                    <p class="text-xs text-slate-400">Student identity and contact details</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">

                {{-- Full Name --}}
                <div>
                    <label class="block text-xs font-semibold text-slate-600 mb-1.5">
                        Full Name <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="name" value="{{ old('name') }}"
                           placeholder="e.g. Emeka Okafor"
                           class="text-sm w-full rounded-lg border border-gray-300 bg-white py-2 px-3 text-gray-700 focus:outline-none focus:border-fuchsia-300 transition-all @error('name') border-red-400 @enderror"
                           required />
                    @error('name') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                </div>

                {{-- Email --}}
                <div>
                    <label class="block text-xs font-semibold text-slate-600 mb-1.5">Email Address (Optional)</label>
                    <input type="email" name="email" value="{{ old('email') }}"
                           placeholder="e.g. emeka@school.com, fola@gmail.com"
                           class="text-sm w-full rounded-lg border border-gray-300 bg-white py-2 px-3 text-gray-700 focus:outline-none focus:border-fuchsia-300 transition-all @error('email') border-red-400 @enderror" />
                    @error('email') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                </div>

                {{-- Password --}}
<div>
    <label class="block text-xs font-semibold text-slate-600 mb-1.5">
        Password <span class="text-red-500">*</span>
    </label>
    <div class="relative">
        <input type="password" 
               name="password" 
               id="password"
               placeholder="Enter password"
               class="text-sm w-full rounded-lg border border-gray-300 bg-white py-2 px-3 pr-10 text-gray-700 focus:outline-none focus:border-fuchsia-300 transition-all @error('password') border-red-400 @enderror" 
               required />
        <button type="button" 
                onclick="togglePassword()" 
                class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600">
            <i id="passwordIcon" class="fa fa-eye-slash text-sm"></i>
        </button>
    </div>
    @error('password') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
</div>

                {{-- Phone --}}
                <div>
                    <label class="block text-xs font-semibold text-slate-600 mb-1.5">Student/Parent/Guardian Phone Number</label>
                    <input type="text" name="phone" value="{{ old('phone') }}"
                           placeholder="e.g. 08012345678"
                           class="text-sm w-full rounded-lg border border-gray-300 bg-white py-2 px-3 text-gray-700 focus:outline-none focus:border-fuchsia-300 transition-all" />
                </div>

                {{-- Gender --}}
                <div>
                    <label class="block text-xs font-semibold text-slate-600 mb-1.5">Gender</label>
                    <select name="gender"
                            class="text-sm w-full rounded-lg border border-gray-300 bg-white py-2 px-3 text-gray-700 focus:outline-none focus:border-fuchsia-300 transition-all">
                        <option value="">-- Select Gender --</option>
                        <option value="male"   {{ old('gender') === 'male'   ? 'selected' : '' }}>Male</option>
                        <option value="female" {{ old('gender') === 'female' ? 'selected' : '' }}>Female</option>
                    </select>
                </div>

            </div>
        </div>

        {{-- SECTION 2: SCHOOL INFO --}}
        <div class="bg-white shadow-soft-xl rounded-2xl p-6 mb-5 mt-2">
            <div class="flex items-center gap-3 mb-5 pb-4 border-b border-gray-100">
                <div class="w-8 h-8 rounded-lg bg-gradient-to-tl from-green-500 to-emerald-400 flex items-center justify-center shadow-soft-md">
                    <i class="fa fa-school text-black text-xs"></i>
                </div>
                <div>
                    <h6 class="font-bold text-slate-700 mb-0">School Information</h6>
                    <p class="text-xs text-slate-400">Student ID, class and assigned teacher</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">

                {{-- Student ID (Auto-generated, editable) --}}
<div>
    <label class="block text-xs font-semibold text-slate-600 mb-1.5">
        Student ID <span class="text-red-500">*</span>
    </label>
    <div class="relative">
        <input type="text" 
               name="student_id" 
               id="student_id"
               value="{{ old('student_id', $generatedStudentId ?? '') }}"
               placeholder="e.g. ST-ID-2024-001"
               class="text-sm w-full rounded-lg border border-gray-300 bg-white py-2 px-3 text-gray-700 focus:outline-none focus:border-fuchsia-300 transition-all @error('student_id') border-red-400 @enderror"
               required />
        <button type="button" 
                onclick="regenerateStudentId()" 
                class="absolute right-2 top-1/2 -translate-y-1/2 text-xs text-blue-500 hover:text-blue-700">
            <i class="fa fa-refresh"></i>
        </button>
    </div>
    <p class="text-xs text-slate-400 mt-1">Auto-generated, can be edited</p>
    @error('student_id') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
</div>

                {{-- Class --}}
<div>
    <label class="block text-xs font-semibold text-slate-600 mb-1.5">
        Class <span class="text-red-500">*</span>
    </label>
    
    @if($classes->count() > 0)
        <select name="class_id"
                class="text-sm w-full rounded-lg border border-gray-300 bg-white py-2 px-3 text-gray-700 focus:outline-none focus:border-fuchsia-300 transition-all"
                required>
            <option value="">-- Select Class --</option>
            @foreach($classes as $class)
                <option value="{{ $class->id }}"
                    {{ old('class_id') == $class->id ? 'selected' : '' }}>
                    {{ $class->name }}
                </option>
            @endforeach
        </select>
    @else
        <div class="bg-red-50 border border-red-200 rounded-lg p-4 text-center">
            <div class="text-red-600 text-sm mb-2">
                📚 No classes available
            </div>
            <a href="{{ route('tenant.classes.index', $subdomain) }}" 
               class="inline-flex items-center gap-2 px-4 py-2 bg-fuchsia-600 text-white text-sm font-medium rounded-lg hover:bg-fuchsia-700 transition">
                <span>➕</span> Add Class Now
            </a>
        </div>
    @endif
    
    @error('class_id') 
        <p class="text-xs text-red-500 mt-1">{{ $message }}</p> 
    @enderror
</div>

                {{-- Assign Teacher --}}
                <div>
                    <label class="block text-xs font-semibold text-slate-600 mb-1.5">Assign Teacher</label>
                    <select name="teacher_id"
                            class="text-sm w-full rounded-lg border border-gray-300 bg-white py-2 px-3 text-gray-700 focus:outline-none focus:border-fuchsia-300 transition-all @error('teacher_id') border-red-400 @enderror">
                        <option value="">-- Select Teacher --</option>
                        @foreach($teachers as $teacher)
                            <option value="{{ $teacher->id }}"
                                {{ old('teacher_id') == $teacher->id ? 'selected' : '' }}>
                                {{ $teacher->user->name ?? $teacher->name }}
                                @if($teacher->department) — {{ $teacher->department }} @endif
                            </option>
                        @endforeach
                    </select>
                    @error('teacher_id') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                    @if($teachers->isEmpty())
                        <p class="text-xs text-amber-500 mt-1">
                            <i class="fa fa-exclamation-triangle mr-1"></i>
                            No teachers found.
                            <a href="{{ route('tenant.teachers.create', $subdomain) }}" class="underline">Add a teacher first.</a>
                        </p>
                    @endif
                </div>

            </div>
        </div>

        {{-- FORM ACTIONS --}}
        <div class="flex items-center justify-between">
            <a href="{{ route('tenant.students.index', $subdomain) }}"
               class="px-6 py-2.5 text-sm border border-gray-300 rounded-lg text-slate-600 hover:bg-gray-50 transition-all">
                <i class="fa fa-times mr-1"></i> Cancel
            </a>
            <button type="submit"
                    class="px-8 py-2.5 text-sm font-semibold text-white rounded-lg bg-gradient-to-tl from-gray-900 to-slate-700 shadow-soft-md hover:shadow-soft-xl hover:scale-105 transition-all">
                <i class="fa fa-save mr-1"></i> Save Student
            </button>
        </div>

    </form>

</div>

<script>
    function togglePassword() {
        const passwordInput = document.getElementById('password');
        const icon = document.getElementById('passwordIcon');
        
        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            icon.classList.remove('fa-eye-slash');
            icon.classList.add('fa-eye');
        } else {
            passwordInput.type = 'password';
            icon.classList.remove('fa-eye');
            icon.classList.add('fa-eye-slash');
        }
    }
    
    function regenerateStudentId() {
        const year = new Date().getFullYear();
        const random = String(Math.floor(Math.random() * 9999)).padStart(4, '0');
        document.getElementById('student_id').value = `ST-ID-${year}-${random}`;
    }
</script>

@endsection