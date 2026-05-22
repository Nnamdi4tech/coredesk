@extends('layouts.owner_admin')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex items-center justify-between mb-6">
        <div class="flex items-center gap-3">
            <a href="{{ route('owner.helpline.index') }}" class="text-slate-400 hover:text-slate-600">
                <i class="fa fa-arrow-left"></i>
            </a>
            <div>
                <h3 class="text-2xl font-bold text-slate-700">Ticket #{{ $ticket->ticket_number }}</h3>
                <p class="text-sm text-slate-400">From {{ $ticket->tenant->name }} ({{ $ticket->tenant->subdomain }}.coredesk.com.ng)</p>
            </div>
        </div>
        <div>
            <form action="{{ route('owner.helpline.update-status', $ticket->id) }}" method="POST" class="inline">
                @csrf
                <select name="status" onchange="this.form.submit()" 
                        class="text-sm px-3 py-1.5 rounded-lg border border-gray-200
                        @if($ticket->status == 'open') bg-blue-50 text-blue-600 border-blue-200
                        @elseif($ticket->status == 'in_progress') bg-amber-50 text-amber-600 border-amber-200
                        @elseif($ticket->status == 'resolved') bg-green-50 text-green-600 border-green-200
                        @else bg-gray-100 text-gray-600 border-gray-200 @endif">
                    <option value="open" {{ $ticket->status == 'open' ? 'selected' : '' }}>📋 Open</option>
                    <option value="in_progress" {{ $ticket->status == 'in_progress' ? 'selected' : '' }}>⚙️ In Progress</option>
                    <option value="resolved" {{ $ticket->status == 'resolved' ? 'selected' : '' }}>✅ Resolved</option>
                    <option value="closed" {{ $ticket->status == 'closed' ? 'selected' : '' }}>🔒 Closed</option>
                </select>
            </form>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        {{-- Main Conversation --}}
        <div class="lg:col-span-2 space-y-4">
            {{-- Original Ticket --}}
            <div class="bg-white shadow-soft-xl rounded-2xl overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100 bg-gradient-to-r from-blue-50 to-cyan-50">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-full bg-gradient-to-tl from-blue-500 to-cyan-400 flex items-center justify-center">
                                <i class="fa fa-user text-black text-sm"></i>
                            </div>
                            <div>
                                <p class="text-sm font-semibold text-slate-700">{{ $ticket->user->name }}</p>
                                <p class="text-xs text-slate-400">{{ $ticket->created_at->format('M d, Y h:i A') }}</p>
                            </div>
                        </div>
                        <div class="flex gap-2">
                            <span class="text-xs px-2 py-1 rounded-full bg-gray-100">
                                {{ str_replace('_', ' ', ucfirst($ticket->category)) }}
                            </span>
                            <span class="text-xs px-2 py-1 rounded-full bg-gray-100">
                                Priority: {{ ucfirst($ticket->priority) }}
                            </span>
                        </div>
                    </div>
                </div>
                <div class="p-6">
                    <h4 class="text-lg font-bold text-slate-700 mb-3">{{ $ticket->subject }}</h4>
                    <p class="text-slate-600 leading-relaxed">{{ nl2br(e($ticket->message)) }}</p>
                    
                    @if($ticket->contact_phone || $ticket->contact_email)
                    <div class="mt-4 pt-3 border-t border-gray-100 flex gap-4 text-xs text-slate-400">
                        @if($ticket->contact_phone)<span><i class="fa fa-phone"></i> {{ $ticket->contact_phone }}</span>@endif
                        @if($ticket->contact_email)<span><i class="fa fa-envelope"></i> {{ $ticket->contact_email }}</span>@endif
                        <span><i class="fa fa-comment"></i> Prefers: {{ ucfirst($ticket->preferred_contact) }}</span>
                    </div>
                    @endif
                </div>
            </div>

            {{-- Replies --}}
            @foreach($ticket->replies as $reply)
            <div class="bg-white shadow-soft-xl rounded-2xl overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100 
                    @if(!$reply->is_owner_reply) bg-gradient-to-r from-gray-50 to-slate-50 @endif">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-full 
                                @if($reply->is_owner_reply) bg-gradient-to-tl from-purple-500 to-pink-500
                                @else bg-gradient-to-tl from-gray-500 to-gray-400 @endif
                                flex items-center justify-center">
                                <i class="fa {{ $reply->is_owner_reply ? 'fa-star' : 'fa-user' }} text-black text-sm"></i>
                            </div>
                            <div>
                                <p class="text-sm font-semibold text-slate-700">
                                    @if($reply->is_owner_reply)
                                        CoreDesk Support Team
                                    @else
                                        {{ $reply->user->name }} ({{ $ticket->tenant->name }})
                                    @endif
                                </p>
                                <p class="text-xs text-slate-400">{{ $reply->created_at->format('M d, Y h:i A') }}</p>
                            </div>
                        </div>
                        @if($reply->is_owner_reply)
                            <span class="text-xs px-2 py-1 rounded-full bg-purple-100 text-purple-600">
                                <i class="fa fa-check-circle"></i> Official Reply
                            </span>
                        @endif
                    </div>
                </div>
                <div class="p-6">
                    <p class="text-slate-600 leading-relaxed">{{ nl2br(e($reply->reply)) }}</p>
                </div>
            </div>
            @endforeach

            {{-- Reply Form --}}
            <div class="bg-white shadow-soft-xl rounded-2xl overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100">
                    <h6 class="font-bold text-slate-700">Reply to {{ $ticket->tenant->name }}</h6>
                </div>
                <form method="POST" action="{{ route('owner.helpline.reply', $ticket->id) }}" class="p-6">
                    @csrf
                    <textarea name="reply" rows="5" required 
                              placeholder="Type your reply here..."
                              class="w-full text-sm rounded-lg border border-gray-200 py-2.5 px-3 focus:outline-none focus:border-purple-300"></textarea>
                    <div class="flex items-center justify-end gap-3 mt-4">
                        <button type="submit" name="status" value="in_progress"
                                class="px-6 py-2.5 text-sm font-semibold text-white rounded-lg bg-gradient-to-tl from-amber-500 to-orange-500 shadow-soft-md hover:shadow-soft-xl hover:scale-105 transition-all">
                            <i class="fa fa-paper-plane mr-1"></i> Send & Keep Open
                        </button>
                        <button type="submit" name="status" value="resolved"
                                class="px-6 py-2.5 text-sm font-semibold text-white rounded-lg bg-gradient-to-tl from-green-600 to-emerald-500 shadow-soft-md hover:shadow-soft-xl hover:scale-105 transition-all">
                            <i class="fa fa-check-circle mr-1"></i> Send & Resolve
                        </button>
                    </div>
                </form>
            </div>
        </div>

        {{-- Sidebar --}}
        <div class="space-y-4">
            {{-- Ticket Info --}}
            <div class="bg-white shadow-soft-xl rounded-2xl overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100">
                    <h6 class="font-bold text-slate-700">Ticket Information</h6>
                </div>
                <div class="p-6 space-y-3">
                    <div>
                        <p class="text-xs text-slate-400">Ticket Number</p>
                        <p class="text-sm font-mono font-semibold">{{ $ticket->ticket_number }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-slate-400">School</p>
                        <p class="text-sm font-semibold">{{ $ticket->tenant->name }}</p>
                        <p class="text-xs text-slate-400">{{ $ticket->tenant->subdomain }}.coredesk.com.ng</p>
                    </div>
                    <div>
                        <p class="text-xs text-slate-400">Created By</p>
                        <p class="text-sm">{{ $ticket->user->name }} ({{ $ticket->user->email }})</p>
                    </div>
                    <div>
                        <p class="text-xs text-slate-400">Created</p>
                        <p class="text-sm">{{ $ticket->created_at->format('M d, Y h:i A') }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-slate-400">Last Updated</p>
                        <p class="text-sm">{{ $ticket->updated_at->diffForHumans() }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-slate-400">Preferred Contact</p>
                        <p class="text-sm">{{ ucfirst($ticket->preferred_contact) }}</p>
                    </div>
                </div>
            </div>

            {{-- Contact Info --}}
            <div class="bg-gradient-to-r from-purple-50 to-pink-50 rounded-2xl p-5">
                <div class="flex items-center gap-3 mb-4">
                    <i class="fa fa-headset text-purple-600 text-xl"></i>
                    <h6 class="font-bold text-slate-700">Support Team</h6>
                </div>
                <div class="space-y-3">
                    <a href="tel:+2348137159867" class="flex items-center gap-3 p-3 bg-white rounded-xl">
                        <i class="fa fa-phone text-green-600 text-lg"></i>
                        <div>
                            <p class="text-xs text-slate-400">Call</p>
                            <p class="text-sm font-semibold">+234 813 715 9867</p>
                        </div>
                    </a>
                    <a href="https://wa.me/2348137159867" target="_blank" class="flex items-center gap-3 p-3 bg-white rounded-xl">
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
</div>
@endsection