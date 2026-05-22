@extends('layouts.owner_admin')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex flex-wrap items-center justify-between mb-6">
        <div>
            <h3 class="text-2xl font-bold text-slate-700">Support Center</h3>
            <p class="text-sm text-slate-400">Manage all support tickets from schools</p>
        </div>
        <div>
            <a href="{{ route('owner.helpline.announcements') }}" 
               class="px-5 py-2.5 text-sm font-semibold text-white rounded-lg bg-gradient-to-tl from-purple-600 to-pink-500 shadow-soft-md hover:shadow-soft-xl hover:scale-105 transition-all">
                <i class="fa fa-bullhorn mr-1"></i> Announcements
            </a>
        </div>
    </div>

    {{-- Statistics Cards --}}
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
        <div class="bg-white rounded-xl shadow-soft-md p-4">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs text-slate-400 uppercase">Total Tickets</p>
                    <p class="text-2xl font-bold text-slate-700">{{ $stats['total'] }}</p>
                </div>
                <div class="w-12 h-12 rounded-xl bg-blue-100 flex items-center justify-center">
                    <i class="fa fa-ticket-alt text-blue-600 text-xl"></i>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-xl shadow-soft-md p-4">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs text-slate-400 uppercase">Open</p>
                    <p class="text-2xl font-bold text-amber-600">{{ $stats['open'] }}</p>
                </div>
                <div class="w-12 h-12 rounded-xl bg-amber-100 flex items-center justify-center">
                    <i class="fa fa-clock text-amber-600 text-xl"></i>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-xl shadow-soft-md p-4">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs text-slate-400 uppercase">In Progress</p>
                    <p class="text-2xl font-bold text-blue-600">{{ $stats['in_progress'] }}</p>
                </div>
                <div class="w-12 h-12 rounded-xl bg-blue-100 flex items-center justify-center">
                    <i class="fa fa-spinner text-blue-600 text-xl"></i>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-xl shadow-soft-md p-4">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs text-slate-400 uppercase">Resolved</p>
                    <p class="text-2xl font-bold text-green-600">{{ $stats['resolved'] }}</p>
                </div>
                <div class="w-12 h-12 rounded-xl bg-green-100 flex items-center justify-center">
                    <i class="fa fa-check-circle text-green-600 text-xl"></i>
                </div>
            </div>
        </div>
    </div>

    {{-- Filters --}}
    <div class="bg-white shadow-soft-xl rounded-2xl p-4 mb-6">
        <form method="GET" class="flex flex-wrap items-end gap-4">
            <div>
                <label class="block text-xs font-semibold text-slate-600 mb-1">Status</label>
                <select name="status" class="text-sm rounded-lg border border-gray-200 py-2 px-3">
                    <option value="all">All Status</option>
                    <option value="open" {{ request('status') == 'open' ? 'selected' : '' }}>Open</option>
                    <option value="in_progress" {{ request('status') == 'in_progress' ? 'selected' : '' }}>In Progress</option>
                    <option value="resolved" {{ request('status') == 'resolved' ? 'selected' : '' }}>Resolved</option>
                    <option value="closed" {{ request('status') == 'closed' ? 'selected' : '' }}>Closed</option>
                </select>
            </div>
            <div>
                <label class="block text-xs font-semibold text-slate-600 mb-1">School</label>
                <select name="tenant_id" class="text-sm rounded-lg border border-gray-200 py-2 px-3">
                    <option value="">All Schools</option>
                    @foreach($tenants as $tenant)
                        <option value="{{ $tenant->id }}" {{ request('tenant_id') == $tenant->id ? 'selected' : '' }}>
                            {{ $tenant->name }} ({{ $tenant->subdomain }})
                        </option>
                    @endforeach
                </select>
            </div>
            <div>
                <button type="submit" class="px-4 py-2 text-sm font-semibold text-white bg-blue-600 rounded-lg hover:bg-blue-700">
                    <i class="fa fa-filter mr-1"></i> Filter
                </button>
                <a href="{{ route('owner.helpline.index') }}" class="px-4 py-2 text-sm font-semibold text-slate-600 border border-gray-300 rounded-lg hover:bg-gray-50">
                    <i class="fa fa-times mr-1"></i> Clear
                </a>
            </div>
        </form>
    </div>

    {{-- Tickets Table --}}
    <div class="bg-white shadow-soft-xl rounded-2xl overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-slate-500">Ticket #</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-slate-500">School</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-slate-500">Subject</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-slate-500">From</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-slate-500">Category</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-slate-500">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-slate-500">Date</th>
                        <th class="px-6 py-3 text-center text-xs font-semibold text-slate-500">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($tickets as $ticket)
                    @php
                        $unreadReplies = $ticket->unreadRepliesForOwner()->count();
                    @endphp
                    <tr class="border-t border-gray-100 hover:bg-gray-50 transition">
                        <td class="px-6 py-4 text-sm font-mono text-slate-600">{{ $ticket->ticket_number }}</td>
                        <td class="px-6 py-4">
                            <div>
                                <p class="text-sm font-semibold text-slate-700">{{ $ticket->tenant->name ?? 'N/A' }}</p>
                                <p class="text-xs text-slate-400">{{ $ticket->tenant->subdomain ?? '' }}.coredesk.com.ng</p>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-2">
                                <span class="text-sm font-semibold text-slate-700">{{ Str::limit($ticket->subject, 40) }}</span>
                                @if($unreadReplies > 0)
                                    <span class="bg-red-500 text-white text-xs px-2 py-0.5 rounded-full">{{ $unreadReplies }}</span>
                                @endif
                            </div>
                        </td>
                        <td class="px-6 py-4 text-sm text-slate-600">{{ $ticket->user->name }}</td>
                        <td class="px-6 py-4">
                            <span class="text-xs px-2 py-1 rounded-full 
                                @if($ticket->category == 'bug') bg-red-100 text-red-600
                                @elseif($ticket->category == 'feature_request') bg-green-100 text-green-600
                                @elseif($ticket->category == 'billing') bg-amber-100 text-amber-600
                                @else bg-gray-100 text-gray-600 @endif">
                                {{ str_replace('_', ' ', ucfirst($ticket->category)) }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <form action="{{ route('owner.helpline.update-status', $ticket->id) }}" method="POST" class="inline">
                                @csrf
                                <select name="status" onchange="this.form.submit()" 
                                        class="text-xs px-2 py-1 rounded-full border-0 cursor-pointer
                                        @if($ticket->status == 'open') bg-blue-50 text-blue-600
                                        @elseif($ticket->status == 'in_progress') bg-amber-50 text-amber-600
                                        @elseif($ticket->status == 'resolved') bg-green-50 text-green-600
                                        @else bg-gray-100 text-gray-600 @endif">
                                    <option value="open" {{ $ticket->status == 'open' ? 'selected' : '' }}>Open</option>
                                    <option value="in_progress" {{ $ticket->status == 'in_progress' ? 'selected' : '' }}>In Progress</option>
                                    <option value="resolved" {{ $ticket->status == 'resolved' ? 'selected' : '' }}>Resolved</option>
                                    <option value="closed" {{ $ticket->status == 'closed' ? 'selected' : '' }}>Closed</option>
                                </select>
                            </form>
                        </td>
                        <td class="px-6 py-4 text-sm text-slate-500">{{ $ticket->created_at->format('M d, Y') }}</td>
                        <td class="px-6 py-4 text-center">
                            <a href="{{ route('owner.helpline.show', $ticket->id) }}" 
                               class="text-blue-600 hover:text-blue-800 text-sm font-semibold">
                                <i class="fa fa-eye mr-1"></i> View
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="px-6 py-12 text-center">
                            <i class="fa fa-ticket-alt text-gray-300 text-4xl mb-2 block"></i>
                            <p class="text-slate-500">No support tickets found</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-6 py-4 border-t border-gray-100">
            {{ $tickets->appends(request()->query())->links() }}
        </div>
    </div>
</div>
@endsection