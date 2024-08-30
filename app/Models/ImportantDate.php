<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ImportantDate extends Model
{
    protected $fillable = [
        'project_id',
        'transaction_id',
        'name',
        'date',
        'description',
        'is_reminder',
        'type',
        'amount'
    ];

    protected $casts = [
        'date' => 'date',
        'is_reminder' => 'boolean',
        'amount' => 'integer',
    ];

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    public function transaction(): BelongsTo
    {
        return $this->belongsTo(Transaction::class);
    }
}
