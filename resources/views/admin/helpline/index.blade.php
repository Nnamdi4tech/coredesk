{{-- resources/views/admin/helpline/index.blade.php --}}
@extends('layouts.admin')

@section('content')
@php $subdomain = request()->route('subdomain'); @endphp

<div class="w-full px-6 py-6 mx-auto">
    <div class="flex flex-wrap items-center justify-between mb-6">
        <div>
            <h3 class="text-2xl font-bold text-slate-700">Support Center</h3>
            <p class="text-sm text-slate-400">Get help, report issues, or suggest features</p>
        </div>
        <div>
            <a href="{{ route('tenant.helpline.create', $subdomain) }}" 
               class="px-5 py-2.5 text-sm font-semibold text-white rounded-lg bg-gradient-to-tl from-blue-600 to-cyan-500 shadow-soft-md hover:shadow-soft-xl hover:scale-105 transition-all">
                <i class="fa fa-plus mr-1"></i> New Ticket
            </a>
        </div>
    </div>

    {{-- General Announcements --}}
    @if($announcements->where('is_active', true)->count() > 0)
    <div class="mb-6">
        <div class="flex items-center gap-2 mb-3">
            <i class="fa fa-bullhorn text-amber-500"></i>
            <h5 class="text-sm font-bold text-slate-600">Announcements from CoreDesk</h5>
        </div>
        @foreach($announcements->where('is_active', true) as $announcement)
            @php $isRead = $announcement->isReadByTenant(auth()->user()->tenant_id); @endphp
            <div class="bg-gradient-to-r from-amber-50 to-orange-50 border border-amber-200 rounded-xl p-4 mb-3 {{ !$isRead ? 'border-l-4 border-l-amber-500' : '' }}" id="announcement-{{ $announcement->id }}">
                <div class="flex items-start justify-between">
                    <div class="flex-1">
                        <div class="flex items-center gap-2 mb-1">
                            <span class="text-xs font-semibold text-amber-600 bg-amber-100 px-2 py-0.5 rounded-full">
                                <i class="fa fa-megaphone mr-1 text-xs"></i> IMPORTANT
                            </span>
                            <span class="text-xs text-slate-400">{{ $announcement->created_at->format('M d, Y') }}</span>
                        </div>
                        <h4 class="text-base font-bold text-slate-700 mb-1">{{ $announcement->title }}</h4>
                        <p class="text-sm text-slate-600">{{ $announcement->content }}</p>
                    </div>
                    @if(!$isRead)
                    <button onclick="markAnnouncementRead({{ $announcement->id }})" 
                            class="ml-3 px-3 py-1 text-xs font-semibold text-amber-600 bg-amber-100 rounded-lg hover:bg-amber-200 transition">
                        <i class="fa fa-check mr-1"></i> Mark Read
                    </button>
                    @endif
                </div>
            </div>
        @endforeach
    </div>
    @endif

    {{-- Tickets List --}}
    <div class="bg-white shadow-soft-xl rounded-2xl overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100">
            <h6 class="font-bold text-slate-700">My Support Tickets</h6>
            <p class="text-xs text-slate-400 mt-0.5">Track and manage your requests</p>
        </div>

        @if($tickets->count() > 0)
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-slate-500">Ticket #</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-slate-500">Subject</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-slate-500">Category</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-slate-500">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-slate-500">Date</th>
                        <th class="px-6 py-3 text-center text-xs font-semibold text-slate-500">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($tickets as $ticket)
                    @php
                        $unreadReplies = $ticket->unreadRepliesForAdmin()->count();
                    @endphp
                    <tr class="border-t border-gray-100 hover:bg-gray-50 transition">
                        <td class="px-6 py-4 text-sm font-mono text-slate-600">{{ $ticket->ticket_number }}</td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-2">
                                <span class="text-sm font-semibold text-slate-700">{{ $ticket->subject }}</span>
                                @if($unreadReplies > 0)
                                    <span class="bg-red-500 text-white text-xs px-2 py-0.5 rounded-full">{{ $unreadReplies }} new</span>
                                @endif
                            </div>
                        </td>
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
                            <span class="inline-flex items-center gap-1 text-xs font-semibold px-2 py-1 rounded-full
                                @if($ticket->status == 'open') bg-blue-50 text-blue-600
                                @elseif($ticket->status == 'in_progress') bg-amber-50 text-amber-600
                                @elseif($ticket->status == 'resolved') bg-green-50 text-green-600
                                @else bg-gray-100 text-gray-600 @endif">
                                <i class="fa fa-circle text-[6px]"></i>
                                {{ ucfirst(str_replace('_', ' ', $ticket->status)) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-sm text-slate-500">{{ $ticket->created_at->format('M d, Y') }}</td>
                        <td class="px-6 py-4 text-center">
                            <a href="{{ route('tenant.helpline.show', [$subdomain, $ticket->id]) }}" 
                               class="text-blue-600 hover:text-blue-800 text-sm font-semibold">
                                <i class="fa fa-eye mr-1"></i> View
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="px-6 py-4 border-t border-gray-100">
            {{ $tickets->links() }}
        </div>
        @else
        <div class="p-12 text-center">
            <div class="w-20 h-20 rounded-2xl bg-gray-100 flex items-center justify-center mb-4 mx-auto">
                <i class="fa fa-ticket-alt text-gray-400 text-3xl"></i>
            </div>
            <p class="text-slate-500 font-semibold text-lg">No support tickets yet</p>
            <p class="text-slate-400 text-sm mt-1">Need help? Create your first support ticket</p>
            <a href="{{ route('tenant.helpline.create', $subdomain) }}" 
               class="inline-block mt-4 px-4 py-2 text-sm font-semibold text-white bg-blue-600 rounded-lg hover:bg-blue-700">
                <i class="fa fa-plus mr-1"></i> Create Ticket
            </a>
        </div>
        @endif
    </div>

    {{-- Contact Info --}}
    <div class="mt-6 p-4 bg-gradient-to-r from-blue-50 to-cyan-50 rounded-xl border border-blue-100">
        <div class="flex flex-wrap items-center justify-between gap-4">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-lg bg-gradient-to-tl from-blue-500 to-cyan-400 flex items-center justify-center shadow-soft-sm">
                    <i class="fa fa-headset text-black text-sm"></i>
                </div>
                <div>
                    <p class="text-sm font-semibold text-blue-800">Need urgent help?</p>
                    <p class="text-xs text-blue-600">Contact us directly via phone or WhatsApp</p>
                </div>
            </div>
            <div class="flex gap-4">
                <a href="tel:+2348137159867" class="flex items-center gap-2 px-4 py-2 bg-white rounded-lg shadow-sm hover:shadow-md transition">
                    <i class="fa fa-phone text-green-600"></i>
                    <div>
                        <p class="text-xs text-slate-400">Call Us</p>
                        <p class="text-sm font-semibold">+234 813 715 9867</p>
                    </div>
                </a>
                <a href="https://wa.me/2348137159867" target="_blank" class="flex items-center gap-2 px-4 py-2 bg-white rounded-lg shadow-sm hover:shadow-md transition">
                    <i class="fab fa-whatsapp text-green-500 text-lg"></i>
                    <div>
                        <p class="text-xs text-slate-400">WhatsApp</p>
                        <p class="text-sm font-semibold">+234 813 715 9867</p>
                    </div>
                </a>
            </div>
        </div>
    </div>
</div>

<script>
function markAnnouncementRead(announcementId) {
    fetch('{{ route("tenant.helpline.announcement.read", [$subdomain, ""]) }}/' + announcementId, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Content-Type': 'application/json'
        }
    }).then(response => response.json())
      .then(data => {
          if (data.success) {
              document.getElementById('announcement-' + announcementId).style.opacity = '0.7';
              location.reload();
          }
      });
}
</script>
@endsection