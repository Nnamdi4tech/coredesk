@extends('layouts.owner_admin')

@section('content')

<div class="w-full px-6 py-6 mx-auto min-h-screen flex items-center justify-center">
    
    {{-- Login Card --}}
    <div class="w-full max-w-md">
        
        {{-- Card Header --}}
        <div class="mb-6 text-center">
            <div class="inline-block w-16 h-16 rounded-2xl bg-gradient-to-tl from-blue-600 to-cyan-500 flex items-center justify-center shadow-soft-lg mb-4">
                <i class="fa fa-building text-white text-2xl"></i>
            </div>
            <h3 class="text-2xl font-bold text-slate-700">Owner Login</h3>
            <p class="text-sm text-slate-400 mt-1">Access the management portal</p>
        </div>

        {{-- Error Message --}}
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

        {{-- Login Form --}}
        <div class="bg-white shadow-soft-xl rounded-2xl overflow-hidden">
            <div class="flex items-center gap-3 px-6 py-4 border-b border-gray-100">
                <div class="w-8 h-8 rounded-lg bg-gradient-to-tl from-blue-600 to-cyan-500 flex items-center justify-center shadow-soft-md">
                    <i class="fa fa-lock text-white text-xs"></i>
                </div>
                <div>
                    <h6 class="font-bold text-slate-700 mb-0">Login Credentials</h6>
                    <p class="text-xs text-slate-400 mt-0.5">Enter your email and password</p>
                </div>
            </div>

            <form method="POST" action="{{ route('owner.login.post') }}" class="p-6">
                @csrf

                {{-- Email --}}
                <div class="mb-5">
                    <label class="block text-xs font-semibold text-slate-600 mb-1.5">
                        <i class="fa fa-envelope mr-1 text-slate-400"></i> Email Address <span class="text-red-500">*</span>
                    </label>
                    <input type="email" 
                           name="email" 
                           value="{{ old('email') }}"
                           placeholder="admin@school.com"
                           class="text-sm w-full rounded-lg border border-gray-300 bg-white py-2.5 px-3 text-gray-700 focus:outline-none focus:border-fuchsia-300 focus:ring-1 focus:ring-fuchsia-200 transition-all @error('email') border-red-400 @enderror" 
                           required />
                    @error('email') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                </div>

                {{-- Password --}}
                <div class="mb-6">
                    <label class="block text-xs font-semibold text-slate-600 mb-1.5">
                        <i class="fa fa-key mr-1 text-slate-400"></i> Password <span class="text-red-500">*</span>
                    </label>
                    <input type="password" 
                           name="password" 
                           placeholder="Enter your password"
                           class="text-sm w-full rounded-lg border border-gray-300 bg-white py-2.5 px-3 text-gray-700 focus:outline-none focus:border-fuchsia-300 focus:ring-1 focus:ring-fuchsia-200 transition-all @error('password') border-red-400 @enderror" 
                           required />
                    @error('password') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                </div>

                {{-- Login Button --}}
                <button type="submit"
                        class="w-full px-6 py-2.5 text-sm font-semibold text-white rounded-lg bg-gradient-to-tl from-blue-600 to-cyan-500 shadow-soft-md hover:shadow-soft-xl hover:scale-[1.02] transition-all flex items-center justify-center gap-2">
                    <i class="fa fa-sign-in-alt text-sm"></i>
                    Login to Dashboard
                </button>

                {{-- Footer --}}
                <div class="mt-5 pt-4 border-t border-gray-100 text-center">
                    <p class="text-xs text-slate-400">
                        <i class="fa fa-shield-alt mr-1"></i>
                        Secure access only
                    </p>
                </div>
            </form>
        </div>

    </div>

</div>

@endsection