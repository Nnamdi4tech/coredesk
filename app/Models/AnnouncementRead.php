<?php
// app/Models/AnnouncementRead.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AnnouncementRead extends Model
{
    public $timestamps = false;
    
    protected $fillable = [
        'announcement_id', 'tenant_id', 'read_at'
    ];

    protected $casts = [
        'read_at' => 'datetime'
    ];

    public function announcement()
    {
        return $this->belongsTo(GeneralAnnouncement::class);
    }

    public function tenant()
    {
        return $this->belongsTo(Tenant::class);
    }
}