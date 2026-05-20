@extends('layouts.admin')

@section('content')

@php $subdomain = request()->route('subdomain'); @endphp


<div class="w-full px-6 py-6 mx-auto min-h-screen flex items-center justify-center">
    <!-- Spinner Overlay -->
<div id="spinnerOverlay" class="spinner-overlay">
    <div class="spinner-container">
        <div class="spinner"></div>
        <div class="spinner-text">Logging you in... Please wait</div>
    </div>
</div>
    
    {{-- Login Card --}}
    <div class="w-full max-w-md">
        
        {{-- Card Header --}}
        <div class="mb-6 text-center">
            <div class="inline-block w-16 h-16 rounded-2xl bg-gradient-to-tl from-blue-500 to-cyan-400 flex items-center justify-center shadow-soft-lg mb-4">
                <i class="fa fa-graduation-cap text-black text-2xl"></i>
            </div>
            <h3 class="text-2xl font-bold text-slate-700">Student Login</h3>
            <p class="text-sm text-slate-400 mt-1">Access your academic records</p>
        </div>

        {{-- Error Message --}}
        @if(session('error'))
            <div class="p-4 mb-6 text-sm text-red-700 bg-red-50 border border-red-200 rounded-2xl flex items-center gap-3">
                <div class="w-8 h-8 rounded-lg bg-gradient-to-tl from-red-500 to-rose-400 flex items-center justify-center flex-shrink-0">
                    <i class="fa fa-exclamation-circle text-black text-xs"></i>
                </div>
                <p class="font-semibold">{{ session('error') }}</p>
                <button onclick="this.parentElement.remove()" class="ml-auto text-red-400 hover:text-red-600">
                    <i class="fa fa-times text-xs"></i>
                </button>
            </div>
        @endif

        {{-- Login Form --}}
        <div class="bg-white shadow-soft-xl rounded-2xl overflow-hidden">
            <div class="flex items-center gap-3 px-6 py-4 border-b border-gray-100">
                <div class="w-8 h-8 rounded-lg bg-gradient-to-tl from-blue-500 to-cyan-400 flex items-center justify-center shadow-soft-md">
                    <i class="fa fa-lock text-black text-xs"></i>
                </div>
                <div>
                    <h6 class="font-bold text-slate-700 mb-0">Login Credentials</h6>
                    <p class="text-xs text-slate-400 mt-0.5">Enter your student ID and password</p>
                </div>
            </div>

            <form method="POST" action="{{ route('student.login.post', $subdomain) }}" class="p-6">
                @csrf

                {{-- Student ID --}}
                <div class="mb-5">
                    <label class="block text-xs font-semibold text-slate-600 mb-1.5">
                        <i class="fa fa-id-card mr-1 text-slate-400"></i> Student ID <span class="text-red-500">*</span>
                    </label>
                    <input type="text" 
                           name="student_id" 
                           value="{{ old('student_id') }}"
                           placeholder="e.g. STU-2024-001"
                           class="text-sm w-full rounded-lg border border-gray-300 bg-white py-2.5 px-3 text-gray-700 focus:outline-none focus:border-fuchsia-300 focus:ring-1 focus:ring-fuchsia-200 transition-all @error('student_id') border-red-400 @enderror" 
                           required />
                    @error('student_id') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                </div>

                {{-- Password --}}
<div class="mb-6">
    <label class="block text-xs font-semibold text-slate-600 mb-1.5">
        <i class="fa fa-key mr-1 text-slate-400"></i> Password <span class="text-red-500">*</span>
    </label>
    <div class="relative">
        <input type="password" 
               name="password" 
               id="password"
               placeholder="Enter your password"
               class="text-sm w-full rounded-lg border border-gray-300 bg-white py-2.5 px-3 pr-10 text-gray-700 focus:outline-none focus:border-fuchsia-300 focus:ring-1 focus:ring-fuchsia-200 transition-all @error('password') border-red-400 @enderror" 
               required />
        <button type="button" 
                onclick="togglePassword()" 
                class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600 transition-all">
            <i id="passwordIcon" class="fa fa-eye-slash text-sm"></i>
        </button>
    </div>
    @error('password') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
</div>

                {{-- Login Button --}}
                <button type="submit"
                        class="w-full px-6 py-2.5 text-sm font-semibold text-black rounded-lg bg-gradient-to-tl from-blue-600 to-cyan-500 shadow-soft-md hover:shadow-soft-xl hover:scale-[1.02] transition-all flex items-center justify-center gap-2">
                    <i class="fa fa-sign-in-alt text-sm"></i>
                    Login to Dashboard
                </button>

                {{-- Additional Info --}}
                <div class="mt-5 pt-4 border-t border-gray-100 text-center">
                    <p class="text-xs text-slate-400">
                        <i class="fa fa-question-circle mr-1"></i>
                        Contact your class teacher if you forgot your password
                    </p>
                </div>
            </form>
        </div>

    </div>

</div>

<style>
    /* Spinner overlay styles */
.spinner-overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.7);
    display: none;
    justify-content: center;
    align-items: center;
    z-index: 9999;
    backdrop-filter: blur(3px);
}

.spinner {
    width: 50px;
    height: 50px;
    border: 5px solid rgba(255, 255, 255, 0.3);
    border-radius: 50%;
    border-top-color: #3b82f6;
    animation: spin 1s ease-in-out infinite;
}

.spinner-text {
    color: white;
    margin-top: 20px;
    font-size: 1rem;
    text-align: center;
}

.spinner-container {
    background: rgba(0, 0, 0, 0.9);
    padding: 30px;
    border-radius: 12px;
    text-align: center;
}

@keyframes spin {
    to { transform: rotate(360deg); }
}
</style>

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

    // Show spinner when form is submitted
    document.querySelector('form').addEventListener('submit', function(e) {
        const spinner = document.getElementById('spinnerOverlay');
        spinner.style.display = 'flex';
        
        // Change button text and disable it
        const submitBtn = document.querySelector('button[type="submit"]');
        const originalText = submitBtn.innerHTML;
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<i class="fa fa-spinner fa-spin"></i> Logging in...';
        
        // If form has validation errors, hide spinner after 1 second
        setTimeout(function() {
            const hasErrors = document.querySelector('.text-red-500');
            if (hasErrors) {
                spinner.style.display = 'none';
                submitBtn.disabled = false;
                submitBtn.innerHTML = originalText;
            }
        }, 500);
    });
</script>

@endsection