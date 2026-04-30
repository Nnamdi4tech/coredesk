@extends('layouts.owner_admin')

@section('content')

<div class="w-full px-6 py-6 mx-auto">
    
    {{-- PAGE HEADER --}}
    <div class="flex flex-wrap items-center justify-between mb-6 -mx-3">
        <div class="px-3">
            <h3 class="text-2xl font-bold text-slate-700 mb-1">Manage Subscription Plans</h3>
            <p class="text-sm text-slate-400">
                <i class="fa fa-tags mr-1"></i> Billing
                <span class="mx-1 text-slate-300">/</span>
                <span class="text-slate-600">Plans Management</span>
            </p>
        </div>
        <div class="px-3 mt-3 md:mt-0">
            <a href="{{ route('owner.dashboard') }}"
               class="px-4 py-2 text-sm border border-gray-300 rounded-lg text-slate-600 hover:bg-gray-50 transition-all">
                <i class="fa fa-arrow-left mr-1"></i> Back to Dashboard
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

    {{-- CREATE PLAN CARD --}}
    <div class="bg-white shadow-soft-xl rounded-2xl overflow-hidden mb-6">
        <div class="flex items-center gap-3 px-6 py-4 border-b border-gray-100 bg-gradient-to-r from-purple-700 to-pink-500">
            <div class="w-8 h-8 rounded-lg bg-white/20 flex items-center justify-center shadow-soft-md">
                <i class="fa fa-plus-circle text-white text-xs"></i>
            </div>
            <div>
                <h6 class="font-bold text-white mb-0">Create New Plan</h6>
                <p class="text-xs text-green-100 mt-0.5 text-white">Add a new subscription plan for schools</p>
            </div>
        </div>

        <form method="POST" action="{{ route('owner.plan.store') }}" class="p-6">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-xs font-semibold text-slate-600 mb-1.5">
                        <i class="fa fa-tag mr-1 text-slate-400"></i> Plan Name <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="name" required placeholder="e.g. Premium, Basic, Pro" 
                           class="text-sm w-full rounded-lg border border-gray-300 bg-white py-2.5 px-3 text-gray-700 focus:outline-none focus:border-fuchsia-300 transition-all">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-600 mb-1.5">
                        <i class="fa fa-money-bill-wave mr-1 text-slate-400"></i> Price (₦) <span class="text-red-500">*</span>
                    </label>
                    <input type="number" name="price" required placeholder="e.g. 25000" 
                           class="text-sm w-full rounded-lg border border-gray-300 bg-white py-2.5 px-3 text-gray-700 focus:outline-none focus:border-fuchsia-300 transition-all">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-600 mb-1.5">
                        <i class="fa fa-users mr-1 text-slate-400"></i> Max Students
                    </label>
                    <input type="number" name="max_students" placeholder="Leave empty for unlimited" 
                           class="text-sm w-full rounded-lg border border-gray-300 bg-white py-2.5 px-3 text-gray-700 focus:outline-none focus:border-fuchsia-300 transition-all">
                    <p class="text-xs text-slate-400 mt-1">Leave empty for unlimited students</p>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-600 mb-1.5">
                        <i class="fa fa-chalkboard-user mr-1 text-slate-400"></i> Max Teachers
                    </label>
                    <input type="number" name="max_teachers" placeholder="Leave empty for unlimited" 
                           class="text-sm w-full rounded-lg border border-gray-300 bg-white py-2.5 px-3 text-gray-700 focus:outline-none focus:border-fuchsia-300 transition-all">
                    <p class="text-xs text-slate-400 mt-1">Leave empty for unlimited teachers</p>
                </div>

                <div class="md:col-span-2">
                    <label class="block text-xs font-semibold text-slate-600 mb-1.5">
                        <i class="fa fa-align-left mr-1 text-slate-400"></i> Description
                    </label>
                    <textarea name="description" rows="3" placeholder="Describe the plan features and benefits..." 
                              class="text-sm w-full rounded-lg border border-gray-300 bg-white py-2.5 px-3 text-gray-700 focus:outline-none focus:border-fuchsia-300 transition-all"></textarea>
                </div>
            </div>

            <div class="flex justify-end mt-6 pt-4 border-t border-gray-100">
                <button type="submit" class="px-6 py-2.5 text-sm font-semibold text-white rounded-lg bg-gradient-to-tl from-green-600 to-emerald-500 shadow-soft-md hover:shadow-soft-xl hover:scale-105 transition-all">
                    <i class="fa fa-save mr-1"></i> Create Plan
                </button>
            </div>
        </form>
    </div>

    {{-- ALL PLANS TABLE --}}
    <div class="bg-white shadow-soft-xl rounded-2xl overflow-hidden">
        <div class="flex items-center gap-3 px-6 py-4 border-b border-gray-100 bg-gradient-to-r from-blue-600 to-cyan-500">
            <div class="w-8 h-8 rounded-lg bg-white/20 flex items-center justify-center shadow-soft-md">
                <i class="fa fa-list text-white text-xs"></i>
            </div>
            <div>
                <h6 class="font-bold text-white mb-0">All Subscription Plans</h6>
                <p class="text-xs text-blue-100 mt-0.5">Manage existing plans</p>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="items-center w-full mb-0 align-top border-gray-200 text-slate-500">
                <thead class="align-bottom bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xxs font-bold uppercase tracking-wider text-slate-400 opacity-70">Plan Name</th>
                        <th class="px-6 py-3 text-left text-xxs font-bold uppercase tracking-wider text-slate-400 opacity-70">Price (₦)</th>
                        <th class="px-6 py-3 text-center text-xxs font-bold uppercase tracking-wider text-slate-400 opacity-70">Max Students</th>
                        <th class="px-6 py-3 text-center text-xxs font-bold uppercase tracking-wider text-slate-400 opacity-70">Max Teachers</th>
                        <th class="px-6 py-3 text-left text-xxs font-bold uppercase tracking-wider text-slate-400 opacity-70">Description</th>
                        <th class="px-6 py-3 text-center text-xxs font-bold uppercase tracking-wider text-slate-400 opacity-70">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($plans as $plan)
                    <tr class="border-t border-gray-100 hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4 align-middle">
                            <div class="flex items-center gap-2">
                                <div class="w-8 h-8 rounded-lg bg-gradient-to-tl from-indigo-500 to-purple-400 flex items-center justify-center">
                                    <i class="fa fa-crown text-white text-xs"></i>
                                </div>
                                <span class="text-sm font-bold text-slate-700 uppercase">{{ $plan->name }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-4 align-middle">
                            <span class="text-sm font-semibold text-slate-700">₦{{ number_format($plan->price, 0) }}</span>
                        </td>
                        <td class="px-6 py-4 align-middle text-center">
                            <span class="px-3 py-1 text-xs font-semibold rounded-full bg-blue-50 text-blue-600">
                                {{ $plan->max_students ?? '∞' }}
                            </span>
                        </td>
                        <td class="px-6 py-4 align-middle text-center">
                            <span class="px-3 py-1 text-xs font-semibold rounded-full bg-purple-50 text-purple-600">
                                {{ $plan->max_teachers ?? '∞' }}
                            </span>
                        </td>
                        <td class="px-6 py-4 align-middle text-sm text-slate-500 max-w-xs">
                            {{ Str::limit($plan->description, 100) ?? 'No description' }}
                        </td>
                        <td class="px-6 py-4 align-middle text-center">
                            {{-- REPLACE the edit button --}}
                            <a href="{{ route('owner.plan.edit', $plan->id) }}"
                             class="w-7 h-7 rounded-lg bg-amber-50 text-amber-500 flex items-center justify-center hover:bg-amber-100 transition-colors"
                              title="Edit">
                              <i class="fa fa-pen text-xs"></i>
                             </a>
                            <div class="flex items-center justify-center gap-2">
                                
                                <form method="POST" action="{{ route('owner.plan.delete', $plan->id) }}" 
                                      class="inline" 
                                      onsubmit="return confirm('Delete {{ addslashes($plan->name) }} plan? This will affect all schools on this plan.')">
                                    @csrf
                                    <button type="submit" class="w-7 h-7 rounded-lg bg-red-50 text-red-500 flex items-center justify-center hover:bg-red-100 transition-colors" title="Delete">
                                        <i class="fa fa-trash text-xs"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center">
                            <div class="flex flex-col items-center">
                                <div class="w-16 h-16 rounded-2xl bg-gray-100 flex items-center justify-center mb-4">
                                    <i class="fa fa-tags text-gray-400 text-2xl"></i>
                                </div>
                                <p class="text-slate-500 font-semibold">No plans found</p>
                                <p class="text-slate-400 text-sm mt-1">Click "Create New Plan" to add your first subscription plan.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>



@endsection