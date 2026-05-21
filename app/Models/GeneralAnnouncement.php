<?php
// app/Models/GeneralAnnouncement.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GeneralAnnouncement extends Model
{
    protected $fillable = [
        'user_id', 'title', 'content', 'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function reads()
{
    return $this->hasMany(AnnouncementRead::class, 'announcement_id');
}

    public function isReadByTenant($tenantId)
    {
        return $this->reads()->where('tenant_id', $tenantId)->exists();
    }
}