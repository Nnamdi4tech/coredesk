<?php
// app/Http/Controllers/Owner/SupportController.php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SupportTicket;
use App\Models\SupportReply;
use App\Models\GeneralAnnouncement;
use App\Models\AnnouncementRead;
use App\Models\Tenant;
use Illuminate\Support\Facades\Auth;

class SupportController extends Controller
{
    // List all tickets from all schools
    public function index(Request $request)
    {
        $query = SupportTicket::with(['tenant', 'user', 'replies']);
        
        // Filter by status
        if ($request->status && $request->status != 'all') {
            $query->where('status', $request->status);
        }
        
        // Filter by school
        if ($request->tenant_id) {
            $query->where('tenant_id', $request->tenant_id);
        }
        
        $tickets = $query->orderBy('created_at', 'desc')->paginate(15);
        
        $tenants = Tenant::orderBy('name')->get();
        
        $stats = [
            'total' => SupportTicket::count(),
            'open' => SupportTicket::where('status', 'open')->count(),
            'in_progress' => SupportTicket::where('status', 'in_progress')->count(),
            'resolved' => SupportTicket::where('status', 'resolved')->count(),
        ];
        
        return view('owner.helpline.index', compact('tickets', 'tenants', 'stats', 'request'));
    }
    
    // Show single ticket with full conversation
    public function show($ticketId)
    {
        $ticket = SupportTicket::with(['tenant', 'user', 'replies.user'])
            ->findOrFail($ticketId);
        
        // Mark admin replies as read
        SupportReply::where('ticket_id', $ticketId)
            ->where('is_owner_reply', false)
            ->where('is_read', false)
            ->update(['is_read' => true]);
        
        return view('owner.helpline.show', compact('ticket'));
    }
    
    // Reply to ticket from owner
    public function reply(Request $request, $ticketId)
    {
        $request->validate([
            'reply' => 'required|string'
        ]);
        
        $ticket = SupportTicket::findOrFail($ticketId);
        
        SupportReply::create([
            'ticket_id' => $ticketId,
            'user_id' => auth()->id(),
            'reply' => $request->reply,
            'is_owner_reply' => true,
            'is_read' => false
        ]);
        
        // Update ticket status and owner replied flag
        $status = $request->status ?? 'in_progress';
        $ticket->update([
            'status' => $status,
            'is_owner_replied' => true
        ]);
        
        if ($status === 'resolved') {
            $ticket->update(['resolved_at' => now()]);
        }
        
        return redirect()->route('owner.helpline.show', $ticketId)
            ->with('success', 'Reply sent successfully.');
    }
    
    // Update ticket status
    public function updateStatus(Request $request, $ticketId)
    {
        $request->validate([
            'status' => 'required|in:open,in_progress,resolved,closed'
        ]);
        
        $ticket = SupportTicket::findOrFail($ticketId);
        $ticket->update(['status' => $request->status]);
        
        if ($request->status === 'resolved') {
            $ticket->update(['resolved_at' => now()]);
        }
        
        return redirect()->back()->with('success', 'Ticket status updated.');
    }
    
    // Show general announcements page
    public function announcements()
    {
        $announcements = GeneralAnnouncement::with('user')
            ->orderBy('created_at', 'desc')
            ->get();
        
        $tenants = Tenant::select('id', 'name', 'subdomain')->get();
        
        // Track read counts per announcement
        foreach ($announcements as $announcement) {
            $announcement->read_count = AnnouncementRead::where('announcement_id', $announcement->id)->count();
            $announcement->total_tenants = Tenant::count();
        }
        
        return view('owner.helpline.announcements', compact('announcements', 'tenants'));
    }
    
    // Create new announcement
    public function storeAnnouncement(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string'
        ]);
        
        GeneralAnnouncement::create([
            'user_id' => auth()->id(),
            'title' => $request->title,
            'content' => $request->content,
            'is_active' => true
        ]);
        
        return redirect()->route('owner.helpline.announcements') 
            ->with('success', 'Announcement sent to all schools.');
    }
    
    // Update announcement
    public function updateAnnouncement(Request $request, $announcementId)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string'
        ]);
        
        $announcement = GeneralAnnouncement::findOrFail($announcementId);
        $announcement->update([
            'title' => $request->title,
            'content' => $request->content
        ]);
        
        return redirect()->route('owner.helpline.announcements')
            ->with('success', 'Announcement updated.');
    }
    
    // Toggle announcement status
    public function toggleAnnouncement($announcementId)
    {
        $announcement = GeneralAnnouncement::findOrFail($announcementId);
        $announcement->update(['is_active' => !$announcement->is_active]);
        
        return redirect()->back()
            ->with('success', 'Announcement ' . ($announcement->is_active ? 'activated' : 'deactivated'));
    }
    
    // Delete announcement
    public function deleteAnnouncement($announcementId)
    {
        $announcement = GeneralAnnouncement::findOrFail($announcementId);
        $announcement->delete();
        
        return redirect()->back()
            ->with('success', 'Announcement deleted.');
    }
    
    // Get unread count for owner navbar
    public function getUnreadCount()
    {
        $unreadTickets = SupportTicket::whereNotIn('status', ['resolved', 'closed'])
            ->whereDoesntHave('replies', function($q) {
                $q->where('is_owner_reply', true);
            })
            ->orWhereHas('replies', function($q) {
                $q->where('is_owner_reply', false)
                  ->where('is_read', false);
            })
            ->count();
        
        return response()->json([
            'unread_tickets' => $unreadTickets,
            'total' => $unreadTickets
        ]);
    }
}