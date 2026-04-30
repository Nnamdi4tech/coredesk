@extends('layouts.owner_admin')

@section('content')

<div class="w-full px-6 py-6 mx-auto">
    
    {{-- PAGE HEADER --}}
    <div class="flex flex-wrap items-center justify-between mb-6 -mx-3">
        <div class="px-3">
            <h3 class="text-2xl font-bold text-slate-700 mb-1">Owner Dashboard</h3>
            <p class="text-sm text-slate-400">
                <i class="fa fa-home mr-1"></i> Dashboard
                <span class="mx-1 text-slate-300">/</span>
                <span class="text-slate-600">Overview</span>
            </p>
        </div>
        <div class="px-3 mt-3 md:mt-0">
            <form method="POST" action="{{ route('owner.logout') }}" class="inline">
                @csrf
                <button type="submit" class="px-4 py-2 text-sm font-semibold text-white rounded-lg bg-gradient-to-tl from-red-600 to-rose-500 shadow-soft-md hover:shadow-soft-xl hover:scale-105 transition-all">
                    <i class="fa fa-sign-out-alt mr-1"></i> Logout
                </button>
            </form>
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

    {{-- Statistics Cards --}}
    <div class="flex flex-wrap -mx-3 mb-6">
        <div class="w-full max-w-full px-3 mb-6 sm:w-1/2 sm:flex-none xl:mb-0 xl:w-1/4">
            <div class="relative flex flex-col min-w-0 break-words bg-white shadow-soft-xl rounded-2xl bg-clip-border">
                <div class="flex-auto p-4">
                    <div class="flex flex-row -mx-3">
                        <div class="flex-none w-2/3 max-w-full px-3">
                            <p class="mb-0 font-sans text-sm font-semibold leading-normal text-slate-500">Total Schools</p>
                            <h5 class="mb-0 font-bold text-slate-700 text-2xl">{{ $tenants->count() }}</h5>
                        </div>
                        <div class="px-3 text-right basis-1/3">
                            <div class="inline-block w-12 h-12 text-center rounded-lg bg-gradient-to-tl from-blue-500 to-cyan-400">
                                <i class="fa fa-building text-lg relative top-3.5 text-white"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="w-full max-w-full px-3 mb-6 sm:w-1/2 sm:flex-none xl:mb-0 xl:w-1/4">
            <div class="relative flex flex-col min-w-0 break-words bg-white shadow-soft-xl rounded-2xl bg-clip-border">
                <div class="flex-auto p-4">
                    <div class="flex flex-row -mx-3">
                        <div class="flex-none w-2/3 max-w-full px-3">
                            <p class="mb-0 font-sans text-sm font-semibold leading-normal text-slate-500">Active Schools</p>
                            <h5 class="mb-0 font-bold text-green-600 text-2xl">{{ $tenants->where('is_active', true)->count() }}</h5>
                        </div>
                        <div class="px-3 text-right basis-1/3">
                            <div class="inline-block w-12 h-12 text-center rounded-lg bg-gradient-to-tl from-green-500 to-emerald-400">
                                <i class="fa fa-check-circle text-lg relative top-3.5 text-white"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="w-full max-w-full px-3 mb-6 sm:w-1/2 sm:flex-none xl:mb-0 xl:w-1/4">
            <div class="relative flex flex-col min-w-0 break-words bg-white shadow-soft-xl rounded-2xl bg-clip-border">
                <div class="flex-auto p-4">
                    <div class="flex flex-row -mx-3">
                        <div class="flex-none w-2/3 max-w-full px-3">
                            <p class="mb-0 font-sans text-sm font-semibold leading-normal text-slate-500">Inactive Schools</p>
                            <h5 class="mb-0 font-bold text-red-600 text-2xl">{{ $tenants->where('is_active', false)->count() }}</h5>
                        </div>
                        <div class="px-3 text-right basis-1/3">
                            <div class="inline-block w-12 h-12 text-center rounded-lg bg-gradient-to-tl from-red-500 to-rose-400">
                                <i class="fa fa-times-circle text-lg relative top-3.5 text-white"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="w-full max-w-full px-3 mb-6 sm:w-1/2 sm:flex-none xl:mb-0 xl:w-1/4">
            <div class="relative flex flex-col min-w-0 break-words bg-white shadow-soft-xl rounded-2xl bg-clip-border">
                <div class="flex-auto p-4">
                    <div class="flex flex-row -mx-3">
                        <div class="flex-none w-2/3 max-w-full px-3">
                            <p class="mb-0 font-sans text-sm font-semibold leading-normal text-slate-500">Super Admins</p>
                            <h5 class="mb-0 font-bold text-slate-700 text-2xl">{{ $owners->count() }}</h5>
                        </div>
                        <div class="px-3 text-right basis-1/3">
                            <div class="inline-block w-12 h-12 text-center rounded-lg bg-gradient-to-tl from-purple-500 to-pink-400">
                                <i class="fa fa-user-shield text-lg relative top-3.5 text-white"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- All Tenants Table --}}
    <div class="bg-white shadow-soft-xl rounded-2xl overflow-hidden mb-6">
        <div class="flex items-center gap-3 px-6 py-4 border-b border-gray-100">
            <div class="w-8 h-8 rounded-lg bg-gradient-to-tl from-blue-500 to-cyan-400 flex items-center justify-center shadow-soft-md">
                <i class="fa fa-school text-black text-xs"></i>
            </div>
            <div>
                <h6 class="font-bold text-slate-700 mb-0">All Schools (Tenants)</h6>
                <p class="text-xs text-slate-400 mt-0.5">Manage all registered schools</p>
            </div>
        </div>

        {{-- ✅ Scrollbar contained inside card --}}
        <div class="w-full overflow-x-auto">
            <table class="w-full min-w-[900px] mb-0 align-top border-gray-200 text-slate-500">
                <thead class="align-bottom bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xxs font-bold uppercase tracking-wider text-slate-400 opacity-70">School Name</th>
                        <th class="px-6 py-3 text-left text-xxs font-bold uppercase tracking-wider text-slate-400 opacity-70">Subdomain</th>
                        <th class="px-6 py-3 text-left text-xxs font-bold uppercase tracking-wider text-slate-400 opacity-70">Plan</th>
                        <th class="px-6 py-3 text-center text-xxs font-bold uppercase tracking-wider text-slate-400 opacity-70">Status</th>
                        <th class="px-6 py-3 text-center text-xxs font-bold uppercase tracking-wider text-slate-400 opacity-70">Expires At</th>
                        <th class="px-6 py-3 text-center text-xxs font-bold uppercase tracking-wider text-slate-400 opacity-70">Deactivate</th>
                        <th class="px-6 py-3 text-center text-xxs font-bold uppercase tracking-wider text-slate-400 opacity-70">Extend Sub</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($tenants as $tenant)
                    <tr class="border-t border-gray-100 hover:bg-gray-50 transition-colors">

                        {{-- School Name --}}
                        <td class="px-6 py-4 align-middle">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-xl bg-gradient-to-tl from-blue-500 to-cyan-400 flex items-center justify-center text-black text-xs font-bold shadow-soft-md">
                                    {{ strtoupper(substr($tenant->name, 0, 2)) }}
                                </div>
                                <p class="text-sm font-semibold text-slate-700 mb-0">{{ $tenant->name }}</p>
                            </div>
                        </td>

                        {{-- Subdomain --}}
                        <td class="px-6 py-4 align-middle">
                            <code class="text-xs bg-gray-100 px-2 py-1 rounded">{{ $tenant->subdomain }}.coredesk.local</code>
                        </td>

                        {{-- Plan + Update --}}
                        <td class="px-6 py-4 align-middle">
                            <form method="POST"
                                  action="{{ route('owner.tenant.plan', $tenant->id) }}"
                                  class="inline-block"
                                  onsubmit="return confirm('Update plan to the selected option and reset to 30 days for {{ addslashes($tenant->name) }}?')">
                                @csrf
                                <div class="flex items-center gap-2">
                                    <select name="plan"
                                            class="text-sm rounded-lg border border-gray-300 bg-white py-1.5 px-2 text-gray-700 focus:outline-none focus:border-fuchsia-300 transition-all">
                                        <option value="free"    {{ $tenant->plan == 'free'    ? 'selected' : '' }}>Free</option>
                                        <option value="starter" {{ $tenant->plan == 'starter' ? 'selected' : '' }}>Starter</option>
                                        <option value="growth"  {{ $tenant->plan == 'growth'  ? 'selected' : '' }}>Growth</option>
                                        <option value="pro"     {{ $tenant->plan == 'pro'     ? 'selected' : '' }}>Pro</option>
                                    </select>
                                    <button type="submit"
                                            class="px-3 py-1.5 text-xs font-semibold rounded-lg bg-blue-50 text-blue-600 hover:bg-blue-100 transition-all">
                                        <i class="fa fa-save mr-1"></i> Update
                                    </button>
                                </div>
                            </form>
                        </td>

                        {{-- Status Badge --}}
                        <td class="px-6 py-4 align-middle text-center">
                            @if($tenant->is_active)
                                <span class="px-3 py-1 text-xs font-semibold rounded-full bg-green-50 text-green-600">
                                    <i class="fa fa-circle mr-1" style="font-size:6px;"></i> Active
                                </span>
                            @else
                                <span class="px-3 py-1 text-xs font-semibold rounded-full bg-red-50 text-red-600">
                                    <i class="fa fa-circle mr-1" style="font-size:6px;"></i> Inactive
                                </span>
                            @endif
                        </td>

                        {{-- Expires At --}}
                        <td class="px-6 py-4 align-middle text-center text-sm text-slate-600">
                            {{ $tenant->expires_at ? \Carbon\Carbon::parse($tenant->expires_at)->format('d M Y') : 'N/A' }}
                        </td>

                        {{-- Deactivate / Activate --}}
                        <td class="px-6 py-4 align-middle text-center">
                            <form method="POST"
                                  action="{{ route('owner.tenant.toggle', $tenant->id) }}"
                                  class="inline"
                                  onsubmit="return confirm('{{ $tenant->is_active ? 'Deactivate' : 'Activate' }} {{ addslashes($tenant->name) }}? This will immediately affect their access.')">
                                @csrf
                                <button type="submit"
                                        class="px-3 py-1.5 text-xs font-semibold rounded-lg transition-all {{ $tenant->is_active ? 'bg-red-50 text-red-600 hover:bg-red-100' : 'bg-green-50 text-green-600 hover:bg-green-100' }}">
                                    <i class="fa {{ $tenant->is_active ? 'fa-ban' : 'fa-check-circle' }} mr-1"></i>
                                    {{ $tenant->is_active ? 'Deactivate' : 'Activate' }}
                                </button>
                            </form>
                        </td>

                        {{-- Extend +30 Days --}}
                        <td class="px-6 py-4 align-middle text-center">
                            <form method="POST"
                                  action="{{ route('owner.tenant.extend', $tenant->id) }}"
                                  class="inline"
                                  onsubmit="return confirm('Extend subscription by 30 days for {{ addslashes($tenant->name) }}?')">
                                @csrf
                                <button type="submit"
                                        class="px-3 py-1.5 text-xs font-semibold rounded-lg bg-amber-50 text-amber-600 hover:bg-amber-100 transition-all">
                                    <i class="fa fa-calendar-plus mr-1"></i> +30 Days
                                </button>
                            </form>
                        </td>

                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-6 py-12 text-center">
                            <div class="flex flex-col items-center">
                                <div class="w-16 h-16 rounded-2xl bg-gray-100 flex items-center justify-center mb-4">
                                    <i class="fa fa-building text-gray-400 text-2xl"></i>
                                </div>
                                <p class="text-slate-500 font-semibold">No schools found</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Super Admins List --}}
    <div class="bg-white shadow-soft-xl rounded-2xl overflow-hidden">
        <div class="flex items-center gap-3 px-6 py-4 border-b border-gray-100">
            <div class="w-8 h-8 rounded-lg bg-gradient-to-tl from-purple-500 to-pink-400 flex items-center justify-center shadow-soft-md">
                <i class="fa fa-user-shield text-black text-xs"></i>
            </div>
            <div>
                <h6 class="font-bold text-slate-700 mb-0">Super Administrators For Tenant Subdomain</h6>
                <p class="text-xs text-slate-400 mt-0.5">System administrators with full access</p>
            </div>
        </div>

        @forelse($owners as $owner)
<div class="flex items-center justify-between px-6 py-4 border-b border-gray-100 hover:bg-gray-50 transition-colors">
    <div class="flex items-center gap-3">
        <div class="w-10 h-10 rounded-xl bg-gradient-to-tl from-purple-500 to-pink-400 flex items-center justify-center text-black text-sm font-bold shadow-soft-md">
            {{ strtoupper(substr($owner->name, 0, 2)) }}
        </div>
        <div>
            <p class="text-sm font-semibold text-slate-700 mb-0">{{ $owner->name }}</p>
            <p class="text-xs text-slate-400">{{ $owner->email }}</p>

            @if($owner->tenant)
                <p class="text-xs text-blue-500 mt-0.5">
                    <i class="fa fa-globe mr-1"></i>
                    <strong>{{ $owner->tenant->subdomain }}.coredesk.local</strong>
                </p>
                    <p class="text-xs text-slate-400 mt-0.5">
                        <i class="fa fa-map-marker-alt mr-1 text-slate-300"></i>
                        {{ $owner->tenant->location ?? 'N/A'}}
                    </p>
                
                    <p class="text-xs text-slate-400 mt-0.5">
                        <i class="fa fa-phone mr-1 text-slate-300 text-black"></i>
                        {{ $owner->tenant->phone ?? 'N/A' }}
                    </p>
                
            @endif
        </div>
    </div>
    <span class="px-3 py-1 text-xs font-semibold rounded-full bg-amber-50 text-amber-600">
        <i class="fa fa-shield-alt mr-1"></i> Super Admin
    </span>
</div>
@empty
<div class="px-6 py-12 text-center">
    <div class="flex flex-col items-center">
        <div class="w-16 h-16 rounded-2xl bg-gray-100 flex items-center justify-center mb-4">
            <i class="fa fa-users text-gray-400 text-2xl"></i>
        </div>
        <p class="text-slate-500 font-semibold">No super administrators found</p>
    </div>
</div>
@endforelse
</div>

</div>

@endsection