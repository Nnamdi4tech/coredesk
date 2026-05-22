<?php
// app/Models/SupportTicket.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SupportTicket extends Model
{
    protected $fillable = [
        'tenant_id', 'user_id', 'ticket_number', 'subject', 'category',
        'priority', 'message', 'contact_phone', 'contact_email', 
        'preferred_contact', 'status', 'is_owner_replied', 'resolved_at'
    ];

    protected $casts = [
        'resolved_at' => 'datetime',
        'is_owner_replied' => 'boolean'
    ];

    public function tenant()
    {
        return $this->belongsTo(Tenant::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function replies()
{
    return $this->hasMany(SupportReply::class, 'ticket_id'); // explicit foreign key
}
    

    public function unreadReplies()
    {
        return $this->replies()->where('is_read', false);
    }

    // Generate ticket number
    public static function generateTicketNumber($tenantId)
    {
        $year = date('Y');
        $month = date('m');
        $lastTicket = self::whereYear('created_at', $year)->count() + 1;
        return sprintf('SUP-%s-%s-%04d', $year, $month, $lastTicket);
    }

    // Get status badge class
    public function getStatusBadgeClass()
    {
        return match($this->status) {
            'open' => 'bg-yellow-100 text-yellow-800',
            'in_progress' => 'bg-blue-100 text-blue-800',
            'resolved' => 'bg-green-100 text-green-800',
            'closed' => 'bg-gray-100 text-gray-800',
            default => 'bg-gray-100 text-gray-800'
        };
    }

    // Get category badge class
    public function getCategoryBadgeClass()
    {
        return match($this->category) {
            'bug' => 'bg-red-100 text-red-800',
            'feature_request' => 'bg-purple-100 text-purple-800',
            'billing' => 'bg-orange-100 text-orange-800',
            'technical' => 'bg-cyan-100 text-cyan-800',
            'general' => 'bg-gray-100 text-gray-800',
            default => 'bg-gray-100 text-gray-800'
        };
    }






    // app/Models/SupportTicket.php

// For owner: unread replies that came FROM the school (not owner replies)
public function unreadRepliesForOwner()
{
    return $this->hasMany(SupportReply::class, 'ticket_id')
        ->where('is_owner_reply', false)
        ->where('is_read', false);
}

// For admin: unread replies that came FROM the owner
public function unreadRepliesForAdmin()
{
    return $this->hasMany(SupportReply::class, 'ticket_id')
        ->where('is_owner_reply', true)
        ->where('is_read', false);
}
}