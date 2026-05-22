@extends('layouts.owner_admin')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex flex-wrap items-center justify-between mb-6">
        <div>
            <h3 class="text-2xl font-bold text-slate-700">General Announcements</h3>
            <p class="text-sm text-slate-400">Send messages to all schools</p>
        </div>
        <div>
            <a href="{{ route('owner.helpline.index') }}" 
               class="px-5 py-2.5 text-sm font-semibold text-white rounded-lg bg-gradient-to-tl from-blue-600 to-cyan-500 shadow-soft-md hover:shadow-soft-xl hover:scale-105 transition-all">
                <i class="fa fa-ticket-alt mr-1"></i> Back to Tickets
            </a>
        </div>
    </div>

    {{-- Create Announcement --}}
    <div class="bg-white shadow-soft-xl rounded-2xl overflow-hidden mb-6">
        <div class="px-6 py-4 border-b border-gray-100 bg-gradient-to-r from-purple-50 to-pink-50">
            <h6 class="font-bold text-slate-700">Create New Announcement</h6>
            <p class="text-xs text-slate-400">This will be visible to ALL schools</p>
        </div>
        <form method="POST" action="{{ route('owner.helpline.announcements.store') }}" class="p-6">
            @csrf
            <div class="mb-4">
                <label class="block text-xs font-semibold text-slate-600 mb-1.5">Title</label>
                <input type="text" name="title" required 
                       placeholder="e.g., System Maintenance on Sunday"
                       class="w-full text-sm rounded-lg border border-gray-200 py-2.5 px-3 focus:outline-none focus:border-purple-300">
            </div>
            <div class="mb-4">
                <label class="block text-xs font-semibold text-slate-600 mb-1.5">Content</label>
                <textarea name="content" rows="4" required 
                          placeholder="Write your announcement message here..."
                          class="w-full text-sm rounded-lg border border-gray-200 py-2.5 px-3 focus:outline-none focus:border-purple-300"></textarea>
            </div>
            <div class="flex justify-end">
                <button type="submit"
                        class="px-6 py-2.5 text-sm font-semibold text-white rounded-lg bg-gradient-to-tl from-purple-600 to-pink-500 shadow-soft-md hover:shadow-soft-xl hover:scale-105 transition-all">
                    <i class="fa fa-send mr-1"></i> Send to All Schools
                </button>
            </div>
        </form>
    </div>

    {{-- Announcements List --}}
    <div class="bg-white shadow-soft-xl rounded-2xl overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100">
            <h6 class="font-bold text-slate-700">Previous Announcements</h6>
            <p class="text-xs text-slate-400 mt-0.5">Track engagement and manage existing announcements</p>
        </div>

        @if($announcements->count() > 0)
        <div class="divide-y divide-gray-100">
            @foreach($announcements as $announcement)
            <div class="p-6 hover:bg-gray-50 transition">
                <div class="flex items-start justify-between">
                    <div class="flex-1">
                        <div class="flex items-center gap-2 mb-2">
                            <span class="text-xs font-semibold px-2 py-0.5 rounded-full 
                                {{ $announcement->is_active ? 'bg-green-100 text-green-600' : 'bg-gray-100 text-gray-500' }}">
                                <i class="fa {{ $announcement->is_active ? 'fa-check-circle' : 'fa-ban' }} mr-1 text-xs"></i>
                                {{ $announcement->is_active ? 'Active' : 'Inactive' }}
                            </span>
                            <span class="text-xs text-slate-400">{{ $announcement->created_at->format('M d, Y h:i A') }}</span>
                            <span class="text-xs text-slate-400">
                                <i class="fa fa-eye mr-1"></i> 
                                {{ $announcement->read_count ?? 0 }}/{{ $announcement->total_tenants ?? 0 }} schools read
                            </span>
                        </div>
                        <h5 class="text-base font-bold text-slate-700 mb-1">{{ $announcement->title }}</h5>
                        <p class="text-sm text-slate-600">{{ Str::limit($announcement->content, 200) }}</p>
                    </div>
                    <div class="flex gap-2 ml-4">
                        <button onclick="editAnnouncement({{ $announcement->id }}, '{{ addslashes($announcement->title) }}', '{{ addslashes($announcement->content) }}')"
                                class="text-blue-600 hover:text-blue-800 text-sm">
                            <i class="fa fa-edit"></i>
                        </button>
                        <form action="{{ route('owner.helpline.announcements.toggle', $announcement->id) }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" class="text-amber-600 hover:text-amber-800 text-sm">
                                <i class="fa {{ $announcement->is_active ? 'fa-pause' : 'fa-play' }}"></i>
                            </button>
                        </form>
                        <form action="{{ route('owner.helpline.announcements.delete', $announcement->id) }}" method="POST" class="inline" 
                              onsubmit="return confirm('Delete this announcement?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-800 text-sm">
                                <i class="fa fa-trash"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @else
        <div class="p-12 text-center">
            <i class="fa fa-bullhorn text-gray-300 text-4xl mb-2 block"></i>
            <p class="text-slate-500">No announcements yet</p>
            <p class="text-xs text-slate-400">Create your first announcement above</p>
        </div>
        @endif
    </div>
</div>

{{-- Edit Modal --}}
<div id="editModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
    <div class="bg-white rounded-2xl w-full max-w-lg mx-4 p-6">
        <h5 class="text-lg font-bold text-slate-700 mb-4">Edit Announcement</h5>
        <form id="editForm" method="POST">
            @csrf
            <div class="mb-4">
                <label class="block text-xs font-semibold text-slate-600 mb-1.5">Title</label>
                <input type="text" name="title" id="edit_title" required 
                       class="w-full text-sm rounded-lg border border-gray-200 py-2.5 px-3">
            </div>
            <div class="mb-4">
                <label class="block text-xs font-semibold text-slate-600 mb-1.5">Content</label>
                <textarea name="content" id="edit_content" rows="4" required 
                          class="w-full text-sm rounded-lg border border-gray-200 py-2.5 px-3"></textarea>
            </div>
            <div class="flex justify-end gap-3">
                <button type="button" onclick="closeModal()"
                        class="px-4 py-2 text-sm font-semibold text-slate-600 border border-gray-300 rounded-lg">Cancel</button>
                <button type="submit"
                        class="px-4 py-2 text-sm font-semibold text-white bg-blue-600 rounded-lg">Update</button>
            </div>
        </form>
    </div>
</div>

<script>
function editAnnouncement(id, title, content) {
    const modal = document.getElementById('editModal');
    const form = document.getElementById('editForm');
    form.action = '{{ route("owner.helpline.update-announcement", "") }}/' + id;
    document.getElementById('edit_title').value = title;
    document.getElementById('edit_content').value = content;
    modal.classList.remove('hidden');
    modal.classList.add('flex');
}

function closeModal() {
    const modal = document.getElementById('editModal');
    modal.classList.remove('flex');
    modal.classList.add('hidden');
}
</script>
@endsection