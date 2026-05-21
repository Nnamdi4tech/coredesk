<?php
// app/Models/SupportReply.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SupportReply extends Model
{
    protected $fillable = [
        'ticket_id', 'user_id', 'reply', 'is_owner_reply', 'is_read'
    ];

    protected $casts = [
        'is_owner_reply' => 'boolean',
        'is_read' => 'boolean'
    ];

    public function ticket()
    {
        return $this->belongsTo(SupportTicket::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}