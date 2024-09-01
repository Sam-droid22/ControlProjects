<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Client extends Model
{
    protected $fillable = [
        'name',
        'email',
        'phone',
        'address',
        'ruc',
        'last_name',
        'business_name',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',  
    ];

    public function project(): HasMany
    {
        return $this->hasMany(Project::class);
    }
}