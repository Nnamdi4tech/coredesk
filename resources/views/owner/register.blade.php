@extends('layouts.owner_admin')

@section('content')

<div class="w-full px-6 py-6 mx-auto min-h-screen flex items-center justify-center">
    
    <div class="w-full max-w-md">
        
        {{-- Card Header --}}
        <div class="mb-6 text-center">
            <div class="inline-block w-16 h-16 rounded-2xl bg-gradient-to-tl from-purple-600 to-pink-500 flex items-center justify-center shadow-soft-lg mb-4">
                <i class="fa fa-user-shield text-black text-2xl"></i>
            </div>
            <h3 class="text-2xl font-bold text-slate-700">Create Owner Account</h3>
            <p class="text-sm text-slate-400 mt-1">Register a new system owner</p>
        </div>

        {{-- Success Message --}}
        @if(session('success'))
            <div class="p-4 mb-6 text-sm text-green-700 bg-green-50 border border-green-200 rounded-2xl flex items-center gap-3">
                <div class="w-8 h-8 rounded-lg bg-gradient-to-tl from-green-500 to-emerald-400 flex items-center justify-center flex-shrink-0">
                    <i class="fa fa-check text-black text-xs"></i>
                </div>
                <p class="font-semibold">{{ session('success') }}</p>
                <button onclick="this.parentElement.remove()" class="ml-auto text-green-400 hover:text-green-600">
                    <i class="fa fa-times text-xs"></i>
                </button>
            </div>
        @endif

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

        {{-- Validation Errors --}}
        @if($errors->any())
            <div class="p-4 mb-6 text-sm text-red-700 bg-red-50 border border-red-200 rounded-2xl">
                <ul class="list-disc list-inside space-y-1">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Register Form --}}
        <div class="bg-white shadow-soft-xl rounded-2xl overflow-hidden">
            <div class="flex items-center gap-3 px-6 py-4 border-b border-gray-100">
                <div class="w-8 h-8 rounded-lg bg-gradient-to-tl from-purple-600 to-pink-500 flex items-center justify-center shadow-soft-md">
                    <i class="fa fa-user-plus text-black text-xs"></i>
                </div>
                <div>
                    <h6 class="font-bold text-slate-700 mb-0">Owner Details</h6>
                    <p class="text-xs text-slate-400 mt-0.5">Fill in the details below</p>
                </div>
            </div>

            <form method="POST" action="{{ route('owner.register.post') }}" class="p-6">
                @csrf

                {{-- Name --}}
                <div class="mb-5">
                    <label class="block text-xs font-semibold text-slate-600 mb-1.5">
                        <i class="fa fa-user mr-1 text-slate-400"></i> Full Name <span class="text-red-500">*</span>
                    </label>
                    <input type="text"
                           name="name"
                           value="{{ old('name') }}"
                           placeholder="e.g. John Doe"
                           class="text-sm w-full rounded-lg border border-gray-300 bg-white py-2.5 px-3 text-gray-700 focus:outline-none focus:border-fuchsia-300 focus:ring-1 focus:ring-fuchsia-200 transition-all @error('name') border-red-400 @enderror"
                           required />
                    @error('name') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                </div>

                {{-- Email --}}
                <div class="mb-5">
                    <label class="block text-xs font-semibold text-slate-600 mb-1.5">
                        <i class="fa fa-envelope mr-1 text-slate-400"></i> Email Address <span class="text-red-500">*</span>
                    </label>
                    <input type="email"
                           name="email"
                           value="{{ old('email') }}"
                           placeholder="owner@coredesk.com"
                           class="text-sm w-full rounded-lg border border-gray-300 bg-white py-2.5 px-3 text-gray-700 focus:outline-none focus:border-fuchsia-300 focus:ring-1 focus:ring-fuchsia-200 transition-all @error('email') border-red-400 @enderror"
                           required />
                    @error('email') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                </div>

                {{-- Password --}}
                <div class="mb-5">
                    <label class="block text-xs font-semibold text-slate-600 mb-1.5">
                        <i class="fa fa-key mr-1 text-slate-400"></i> Password <span class="text-red-500">*</span>
                    </label>
                    <input type="password"
                           name="password"
                           placeholder="Minimum 8 characters"
                           class="text-sm w-full rounded-lg border border-gray-300 bg-white py-2.5 px-3 text-gray-700 focus:outline-none focus:border-fuchsia-300 focus:ring-1 focus:ring-fuchsia-200 transition-all @error('password') border-red-400 @enderror"
                           required />
                    @error('password') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                </div>

                {{-- Confirm Password --}}
                <div class="mb-6">
                    <label class="block text-xs font-semibold text-slate-600 mb-1.5">
                        <i class="fa fa-key mr-1 text-slate-400"></i> Confirm Password <span class="text-red-500">*</span>
                    </label>
                    <input type="password"
                           name="password_confirmation"
                           placeholder="Repeat your password"
                           class="text-sm w-full rounded-lg border border-gray-300 bg-white py-2.5 px-3 text-gray-700 focus:outline-none focus:border-fuchsia-300 focus:ring-1 focus:ring-fuchsia-200 transition-all"
                           required />
                </div>

                {{-- Submit --}}
                <button type="submit"
                        class="w-full px-6 py-2.5 text-sm font-semibold text-black rounded-lg bg-gradient-to-tl from-purple-700 to-pink-500 shadow-soft-md hover:shadow-soft-xl hover:scale-[1.02] transition-all flex items-center justify-center gap-2">
                    <i class="fa fa-user-plus text-sm"></i>
                    Create Owner Account
                </button>

                {{-- Footer --}}
                <div class="mt-5 pt-4 border-t border-gray-100 text-center">
                    <p class="text-xs text-slate-400">
                        Already have an account?
                        <a href="{{ route('owner.login') }}" class="text-purple-600 font-semibold hover:underline ml-1">
                            Sign In
                        </a>
                    </p>
                </div>
            </form>
        </div>

    </div>

</div>

@endsection