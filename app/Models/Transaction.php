<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_id',
        'category_id',
        'amount',
        'type',
        'date',
        'description',
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}
