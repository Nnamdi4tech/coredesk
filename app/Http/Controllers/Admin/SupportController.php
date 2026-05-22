<?php
// app/Http/Controllers/Admin/SupportController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SupportTicket;
use App\Models\SupportReply;
use App\Models\GeneralAnnouncement;

class SupportController extends Controller
{
    // Display all tickets for the current school
public function index($subdomain)
{
    $tenantId = auth()->user()->tenant_id;
    
    $tickets = SupportTicket::where('tenant_id', $tenantId)
        ->with('user')
        ->orderBy('created_at', 'desc')
        ->paginate(10);
    
    // Get unread count for navbar
    $unreadCount = SupportReply::whereHas('ticket', function($q) use ($tenantId) {
            $q->where('tenant_id', $tenantId);
        })
        ->where('is_read', false)
        ->where('is_owner_reply', true)
        ->count();
    
    // Get unread announcements ← CHANGED count() to get()
    $announcements = GeneralAnnouncement::where('is_active', true)
        ->whereDoesntHave('reads', function($q) use ($tenantId) {
            $q->where('tenant_id', $tenantId);
        })
        ->get();
    
    $stats = [
        'open' => SupportTicket::where('tenant_id', $tenantId)->where('status', 'open')->count(),
        'in_progress' => SupportTicket::where('tenant_id', $tenantId)->where('status', 'in_progress')->count(),
        'resolved' => SupportTicket::where('tenant_id', $tenantId)->where('status', 'resolved')->count(),
    ];
    
    return view('admin.helpline.index', compact('tickets', 'stats', 'unreadCount', 'announcements', 'subdomain'));
}
    
    // Show create ticket form
    public function create($subdomain)
    {
        return view('admin.helpline.create', compact('subdomain'));
    }
    
    // Store new ticket
    public function store(Request $request, $subdomain)
    {
        $validated = $request->validate([
            'subject' => 'required|string|max:255',
            'category' => 'required|in:bug,feature_request,billing,technical,general',
            'priority' => 'required|in:low,medium,high,urgent',
            'message' => 'required|string',
            'contact_phone' => 'nullable|string|max:20',
            'contact_email' => 'nullable|email|max:255',
            'preferred_contact' => 'required|in:email,phone,whatsapp',
        ]);
        
        $tenantId = auth()->user()->tenant_id;
        
        $ticket = SupportTicket::create([
            'tenant_id' => $tenantId,
            'user_id' => auth()->id(),
            'ticket_number' => SupportTicket::generateTicketNumber($tenantId),
            'subject' => $validated['subject'],
            'category' => $validated['category'],
            'priority' => $validated['priority'],
            'message' => $validated['message'],
            'contact_phone' => $validated['contact_phone'],
            'contact_email' => $validated['contact_email'],
            'preferred_contact' => $validated['preferred_contact'],
            'status' => 'open',
        ]);
        
        return redirect()->route('tenant.admin.helpline.show', ['id' => $ticket->id])
             ->with('success', 'Ticket #' . $ticket->ticket_number . ' created successfully.');
    }
    
    // Show single ticket
    public function show($subdomain, $id)
    {
        $tenantId = auth()->user()->tenant_id;
        
        $ticket = SupportTicket::where('id', $id)
            ->where('tenant_id', $tenantId)
            ->with(['replies.user'])
            ->firstOrFail();
        
        // Mark owner replies as read
        SupportReply::where('ticket_id', $ticket->id)
            ->where('is_owner_reply', true)
            ->where('is_read', false)
            ->update(['is_read' => true]);
        
        return view('admin.helpline.show', compact('ticket', 'subdomain'));
    }
    
    // Add reply to ticket
    public function reply(Request $request, $subdomain, $id)
    {
        $validated = $request->validate([
            'reply' => 'required|string',
        ]);
        
        $ticket = SupportTicket::where('id', $id)
            ->where('tenant_id', auth()->user()->tenant_id)
            ->firstOrFail();
        
        // Update ticket status to in_progress if it was open
        if ($ticket->status === 'open') {
            $ticket->update(['status' => 'in_progress']);
        }
        
        SupportReply::create([
            'ticket_id' => $ticket->id,
            'user_id' => auth()->id(),
            'reply' => $validated['reply'],
            'is_owner_reply' => false,
            'is_read' => false,
        ]);
        
        return back()->with('success', 'Reply added successfully.');
    }
    
    // Mark ticket as resolved
    public function resolve($subdomain, $id)
    {
        $ticket = SupportTicket::where('id', $id)
            ->where('tenant_id', auth()->user()->tenant_id)
            ->firstOrFail();
        
        $ticket->update([
            'status' => 'resolved',
            'resolved_at' => now(),
        ]);
        
        return back()->with('success', 'Ticket marked as resolved.');
    }
    
    // Get unread count for AJAX
    public function unreadCount($subdomain)
    {
        $tenantId = auth()->user()->tenant_id;
        
        $unreadTickets = SupportReply::whereHas('ticket', function($q) use ($tenantId) {
                $q->where('tenant_id', $tenantId);
            })
            ->where('is_read', false)
            ->where('is_owner_reply', true)
            ->count();
        
        $unreadAnnouncements = GeneralAnnouncement::where('is_active', true)
            ->whereDoesntHave('reads', function($q) use ($tenantId) {
                $q->where('tenant_id', $tenantId);
            })
            ->count();
        
        return response()->json([
            'unread_tickets' => $unreadTickets,
            'unread_announcements' => $unreadAnnouncements,
            'total' => $unreadTickets + $unreadAnnouncements
        ]);
    }
    
    // Mark announcement as read
    public function markAnnouncementRead($subdomain, $id)
    {
        $tenantId = auth()->user()->tenant_id;
        
        \App\Models\AnnouncementRead::firstOrCreate([
            'announcement_id' => $id,
            'tenant_id' => $tenantId
        ]);
        
        return response()->json(['success' => true]);
    }
}