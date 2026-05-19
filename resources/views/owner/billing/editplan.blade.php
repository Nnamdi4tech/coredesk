@extends('layouts.owner_admin')

@section('content')

<div class="w-full px-6 py-6 mx-auto">

    {{-- PAGE HEADER --}}
    <div class="flex flex-wrap items-center justify-between mb-6 -mx-3">
        <div class="px-3">
            <h3 class="text-2xl font-bold text-slate-700 mb-1">Edit Subscription Plan</h3>
            <p class="text-sm text-slate-400">
                <i class="fa fa-tags mr-1"></i> Billing
                <span class="mx-1 text-slate-300">/</span>
                <a href="{{ route('owner.billing.index') }}" class="text-slate-500 hover:text-slate-700">Plans Management</a>
                <span class="mx-1 text-slate-300">/</span>
                <span class="text-slate-600">Edit Plan</span>
            </p>
        </div>
        <div class="px-3 mt-3 md:mt-0">
            <a href="{{ route('owner.billing.index') }}"
               class="px-4 py-2 text-sm border border-gray-300 rounded-lg text-slate-600 hover:bg-gray-50 transition-all">
                <i class="fa fa-arrow-left mr-1"></i> Back to Plans
            </a>
        </div>
    </div>

    {{-- SUCCESS MESSAGE --}}
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

    {{-- EDIT PLAN CARD --}}
    <div class="bg-white shadow-soft-xl rounded-2xl overflow-hidden max-w-2xl mx-auto">
        <div class="flex items-center gap-3 px-6 py-4 border-b border-gray-100 bg-gradient-to-r from-amber-600 to-orange-500">
            <div class="w-8 h-8 rounded-lg bg-white/20 flex items-center justify-center shadow-soft-md">
                <i class="fa fa-pen text-black text-xs"></i>
            </div>
            <div>
                <h6 class="font-bold text-white mb-0">Edit Plan: <span class="uppercase">{{ $plan->name }}</span></h6>
                <p class="text-xs text-amber-100 mt-0.5">Update the details for this subscription plan</p>
            </div>
        </div>

        <form method="POST" action="{{ route('owner.plan.update', $plan->id) }}" class="p-6">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                <div class="md:col-span-2">
                    <label class="block text-xs font-semibold text-slate-600 mb-1.5">
                        <i class="fa fa-tag mr-1 text-slate-400"></i> Plan Name <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="name" required value="{{ old('name', $plan->name) }}"
                           placeholder="e.g. Premium, Basic, Pro"
                           class="text-sm w-full rounded-lg border border-gray-300 bg-white py-2.5 px-3 text-gray-700 focus:outline-none focus:border-fuchsia-300 transition-all">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-600 mb-1.5">
                        <i class="fa fa-money-bill-wave mr-1 text-slate-400"></i> Price (₦) <span class="text-red-500">*</span>
                    </label>
                    <input type="number" name="price" required value="{{ old('price', $plan->price) }}"
                           placeholder="e.g. 25000"
                           class="text-sm w-full rounded-lg border border-gray-300 bg-white py-2.5 px-3 text-gray-700 focus:outline-none focus:border-fuchsia-300 transition-all">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-600 mb-1.5">
                        <i class="fa fa-users mr-1 text-slate-400"></i> Max Students
                    </label>
                    <input type="number" name="max_students"
                           value="{{ old('max_students', $plan->max_students) }}"
                           placeholder="Leave empty for unlimited"
                           class="text-sm w-full rounded-lg border border-gray-300 bg-white py-2.5 px-3 text-gray-700 focus:outline-none focus:border-fuchsia-300 transition-all">
                    <p class="text-xs text-slate-400 mt-1">Leave empty for unlimited students</p>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-600 mb-1.5">
                        <i class="fa fa-chalkboard-user mr-1 text-slate-400"></i> Max Teachers
                    </label>
                    <input type="number" name="max_teachers"
                           value="{{ old('max_teachers', $plan->max_teachers) }}"
                           placeholder="Leave empty for unlimited"
                           class="text-sm w-full rounded-lg border border-gray-300 bg-white py-2.5 px-3 text-gray-700 focus:outline-none focus:border-fuchsia-300 transition-all">
                    <p class="text-xs text-slate-400 mt-1">Leave empty for unlimited teachers</p>
                </div>

                <div class="md:col-span-2">
                    <label class="block text-xs font-semibold text-slate-600 mb-1.5">
                        <i class="fa fa-align-left mr-1 text-slate-400"></i> Description
                    </label>
                    <textarea name="description" rows="4"
                              placeholder="Describe the plan features and benefits..."
                              class="text-sm w-full rounded-lg border border-gray-300 bg-white py-2.5 px-3 text-gray-700 focus:outline-none focus:border-fuchsia-300 transition-all">{{ old('description', $plan->description) }}</textarea>
                </div>

            </div>

            <div class="flex gap-3 mt-6 pt-4 border-t border-gray-100">
                <a href="{{ route('owner.billing.index') }}"
                   class="flex-1 text-center px-4 py-2.5 text-sm font-semibold text-slate-600 border border-gray-300 rounded-lg hover:bg-gray-50 transition-all">
                    Cancel
                </a>
                <button type="submit"
                        class="flex-1 px-4 py-2.5 text-sm font-semibold text-black rounded-lg bg-gradient-to-tl from-amber-600 to-orange-500 shadow-soft-md hover:shadow-soft-xl hover:scale-105 transition-all">
                    <i class="fa fa-save mr-1"></i> Update Plan
                </button>
            </div>
        </form>
    </div>

</div>

@endsection