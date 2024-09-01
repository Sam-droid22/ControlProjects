<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Project extends Model
{
    protected $fillable = [
        'client_id',
        'name',
        'description',
        'total_price',
        'start_date',
        'due_date',
        'delivery_date',
        'review_date',
        'status',
        'host_expiration_date',
    ];

    protected $casts = [
        'start_date' => 'date',
        'due_date' => 'date',
        'delivery_date' => 'date',
        'review_date' => 'date',
        'host_expiration_date' => 'date',
        'total_price' => 'integer',
    ];

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }

    public function importantDates()
    {
        return $this->hasMany(ImportantDate::class);
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }
}