@extends('layouts.admin')

@section('content')

@php $subdomain = request()->route('subdomain'); @endphp

<div class="w-full px-6 py-6 mx-auto">

    {{-- PAGE HEADER --}}
    <div class="flex items-center justify-between mb-6">
        <div>
            <h3 class="text-xl font-bold text-slate-700 mb-1">Edit Teacher</h3>
            <p class="text-sm text-slate-400">
                <i class="fa fa-home mr-1"></i> Dashboard
                <span class="mx-1 text-slate-300">/</span>
                <a href="{{ route('tenant.teachers.index', $subdomain) }}" class="hover:text-slate-600">Teachers</a>
                <span class="mx-1 text-slate-300">/</span>
                <span class="text-slate-600">Edit</span>
            </p>
        </div>
        <a href="{{ route('tenant.teachers.index', $subdomain) }}"
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

    <form method="POST" action="{{ route('tenant.teachers.update', [$subdomain, $teacher->id]) }}">
        @csrf
        @method('PUT')

        {{-- SECTION 1: PERSONAL INFO --}}
        <div class="bg-white shadow-soft-xl rounded-2xl p-6 mb-5">
            <div class="flex items-center gap-3 mb-5 pb-4 border-b border-gray-100">
                <div class="w-8 h-8 rounded-lg bg-gradient-to-tl from-blue-500 to-cyan-400 flex items-center justify-center shadow-soft-md">
                    <i class="fa fa-id-card text-black text-xs"></i>
                </div>
                <div>
                    <h6 class="font-bold text-slate-700 mb-0">Personal Information</h6>
                    <p class="text-xs text-slate-400">Basic identity and contact details</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">

                {{-- Full Name --}}
                <div>
                    <label class="block text-xs font-semibold text-slate-600 mb-1.5">
                        Full Name <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="name" value="{{ old('name', $teacher->name) }}"
                           placeholder="e.g. John Doe"
                           class="text-sm w-full rounded-lg border border-gray-300 bg-white py-2 px-3 text-gray-700 focus:outline-none focus:border-fuchsia-300 transition-all @error('name') border-red-400 @enderror"
                           required />
                    @error('name') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                </div>

                {{-- Email --}}
                <div>
                    <label class="block text-xs font-semibold text-slate-600 mb-1.5">
                        Email Address <span class="text-red-500">*</span>
                    </label>
                    <input type="email" name="email" value="{{ old('email', $teacher->email) }}"
                           placeholder="e.g. john@school.com"
                           class="text-sm w-full rounded-lg border border-gray-300 bg-white py-2 px-3 text-gray-700 focus:outline-none focus:border-fuchsia-300 transition-all @error('email') border-red-400 @enderror"
                           required />
                    @error('email') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                </div>

                {{-- Phone --}}
                <div>
                    <label class="block text-xs font-semibold text-slate-600 mb-1.5">Phone Number</label>
                    <input type="text" name="phone" value="{{ old('phone', $teacher->phone) }}"
                           placeholder="e.g. 08012345678"
                           class="text-sm w-full rounded-lg border border-gray-300 bg-white py-2 px-3 text-gray-700 focus:outline-none focus:border-fuchsia-300 transition-all" />
                </div>

                {{-- Gender --}}
                <div>
                    <label class="block text-xs font-semibold text-slate-600 mb-1.5">Gender</label>
                    <select name="gender"
                            class="text-sm w-full rounded-lg border border-gray-300 bg-white py-2 px-3 text-gray-700 focus:outline-none focus:border-fuchsia-300 transition-all">
                        <option value="">-- Select Gender --</option>
                        <option value="male" {{ old('gender', $teacher->gender) === 'male' ? 'selected' : '' }}>Male</option>
                        <option value="female" {{ old('gender', $teacher->gender) === 'female' ? 'selected' : '' }}>Female</option>
                    </select>
                </div>

                {{-- Date of Birth --}}
                <div>
                    <label class="block text-xs font-semibold text-slate-600 mb-1.5">Date of Birth</label>
                    <input type="date" name="dob" value="{{ old('dob', $teacher->dob) }}"
                           class="text-sm w-full rounded-lg border border-gray-300 bg-white py-2 px-3 text-gray-700 focus:outline-none focus:border-fuchsia-300 transition-all" />
                </div>

                {{-- Password (optional) --}}
                <div>
                    <label class="block text-xs font-semibold text-slate-600 mb-1.5">
                        New Password
                    </label>
                    <div class="relative">
                        <input type="password" name="password" id="password"
                               placeholder="Leave blank to keep current password"
                               class="text-sm w-full rounded-lg border border-gray-300 bg-white py-2 px-3 pr-10 text-gray-700 focus:outline-none focus:border-fuchsia-300 transition-all" />
                        <button type="button" onclick="togglePassword()" 
                                class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600">
                            <i id="passwordIcon" class="fa fa-eye-slash text-sm"></i>
                        </button>
                    </div>
                    @error('password') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                </div>

                {{-- Address --}}
                <div class="md:col-span-2 lg:col-span-3">
                    <label class="block text-xs font-semibold text-slate-600 mb-1.5">Address</label>
                    <textarea name="address" rows="2"
                              placeholder="e.g. 12 Aba Road, Port Harcourt"
                              class="text-sm w-full rounded-lg border border-gray-300 bg-white py-2 px-3 text-gray-700 focus:outline-none focus:border-fuchsia-300 transition-all resize-none">{{ old('address', $teacher->address) }}</textarea>
                </div>

            </div>
        </div>

        {{-- SECTION 2: EMPLOYMENT INFO --}}
        <div class="bg-white shadow-soft-xl rounded-2xl p-6 mb-5">
            <div class="flex items-center gap-3 mb-5 pb-4 border-b border-gray-100">
                <div class="w-8 h-8 rounded-lg bg-gradient-to-tl from-green-500 to-emerald-400 flex items-center justify-center shadow-soft-md">
                    <i class="fa fa-briefcase text-black text-xs"></i>
                </div>
                <div>
                    <h6 class="font-bold text-slate-700 mb-0">Employment Details</h6>
                    <p class="text-xs text-slate-400">Staff ID, position, department and status</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">

                {{-- Staff ID --}}
                <div>
                    <label class="block text-xs font-semibold text-slate-600 mb-1.5">
                        Staff ID <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="staff_id" value="{{ old('staff_id', $teacher->staff_id) }}"
                           class="text-sm w-full rounded-lg border border-gray-300 bg-white py-2 px-3 text-gray-700 focus:outline-none focus:border-fuchsia-300 transition-all @error('staff_id') border-red-400 @enderror"
                           required />
                    @error('staff_id') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                </div>

                {{-- Employee ID --}}
                <!-- remove the alight for employees if you need it. -->
                <!-- <div>
                    <label class="block text-xs font-semibold text-slate-600 mb-1.5">Employee ID</label>
                    <input type="text" name="employee_id" value="{{ old('employee_id', $teacher->employee_id) }}"
                           placeholder="e.g. EMP-1001"
                           class="text-sm w-full rounded-lg border border-gray-300 bg-white py-2 px-3 text-gray-700 focus:outline-none focus:border-fuchsia-300 transition-all" />
                </div> -->

                {{-- Employment Date --}}
                <div>
                    <label class="block text-xs font-semibold text-slate-600 mb-1.5">Employment Date</label>
                    <input type="date" name="employment_date" value="{{ old('employment_date', $teacher->employment_date) }}"
                           class="text-sm w-full rounded-lg border border-gray-300 bg-white py-2 px-3 text-gray-700 focus:outline-none focus:border-fuchsia-300 transition-all" />
                </div>

                {{-- Employment Type --}}
                <div>
                    <label class="block text-xs font-semibold text-slate-600 mb-1.5">Employment Type</label>
                    <select name="employment_type"
                            class="text-sm w-full rounded-lg border border-gray-300 bg-white py-2 px-3 text-gray-700 focus:outline-none focus:border-fuchsia-300 transition-all">
                        <option value="">-- Select Type --</option>
                        <option value="full_time"  {{ old('employment_type', $teacher->employment_type) === 'full_time'  ? 'selected' : '' }}>Full Time</option>
                        <option value="part_time"  {{ old('employment_type', $teacher->employment_type) === 'part_time'  ? 'selected' : '' }}>Part Time</option>
                        <option value="contract"   {{ old('employment_type', $teacher->employment_type) === 'contract'   ? 'selected' : '' }}>Contract</option>
                        <option value="volunteer"  {{ old('employment_type', $teacher->employment_type) === 'volunteer'  ? 'selected' : '' }}>Volunteer</option>
                    </select>
                </div>

                {{-- Department (Text Input) --}}
                <div>
                    <label class="block text-xs font-semibold text-slate-600 mb-1.5">Department</label>
                    <input type="text" name="department" value="{{ old('department', $teacher->department) }}"
                           placeholder="e.g. Science, Mathematics, English, Arts"
                           class="text-sm w-full rounded-lg border border-gray-300 bg-white py-2 px-3 text-gray-700 focus:outline-none focus:border-fuchsia-300 transition-all" />
                </div>

                {{-- Position (Text Input) --}}
                <div>
                    <label class="block text-xs font-semibold text-slate-600 mb-1.5">Position</label>
                    <input type="text" name="position" value="{{ old('position', $teacher->position) }}"
                           placeholder="e.g. Teacher, HOD, Principal, Vice Principal"
                           class="text-sm w-full rounded-lg border border-gray-300 bg-white py-2 px-3 text-gray-700 focus:outline-none focus:border-fuchsia-300 transition-all" />
                </div>

                {{-- Subject --}}
                <div>
                    <label class="block text-xs font-semibold text-slate-600 mb-1.5">Subject</label>
                    <input type="text" name="subject" value="{{ old('subject', $teacher->subject) }}"
                           placeholder="e.g. Physics, Further Maths"
                           class="text-sm w-full rounded-lg border border-gray-300 bg-white py-2 px-3 text-gray-700 focus:outline-none focus:border-fuchsia-300 transition-all" />
                </div>

                {{-- Status --}}
                <div>
                    <label class="block text-xs font-semibold text-slate-600 mb-1.5">Status</label>
                    <select name="status"
                            class="text-sm w-full rounded-lg border border-gray-300 bg-white py-2 px-3 text-gray-700 focus:outline-none focus:border-fuchsia-300 transition-all">
                        <option value="active"    {{ old('status', $teacher->status) === 'active'    ? 'selected' : '' }}>Active</option>
                        <option value="inactive"  {{ old('status', $teacher->status) === 'inactive'  ? 'selected' : '' }}>Inactive</option>
                        <option value="on_leave"  {{ old('status', $teacher->status) === 'on_leave'  ? 'selected' : '' }}>On Leave</option>
                        <option value="suspended" {{ old('status', $teacher->status) === 'suspended' ? 'selected' : '' }}>Suspended</option>
                    </select>
                </div>

            </div>
        </div>

        {{-- FORM ACTIONS --}}
        <div class="flex items-center justify-between">
            <a href="{{ route('tenant.teachers.index', $subdomain) }}"
               class="px-6 py-2.5 text-sm border border-gray-300 rounded-lg text-slate-600 hover:bg-gray-50 transition-all">
                <i class="fa fa-times mr-1"></i> Cancel
            </a>
            <button type="submit"
                    class="px-8 py-2.5 text-sm font-semibold text-white rounded-lg bg-gradient-to-tl from-gray-900 to-slate-700 shadow-soft-md hover:shadow-soft-xl hover:scale-105 transition-all">
                <i class="fa fa-save mr-1"></i> Update Teacher
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
</script>

@endsection