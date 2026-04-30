<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tenant extends Model
{
    protected $fillable = [
        'name',
        'subdomain',
        'plan',
        'starts_at',
        'expires_at',
        'is_active',
        'location',
        'phone', 
        
    ];

    // Add this relationship
    public function users()
    {
        return $this->hasMany(User::class);
    }



}