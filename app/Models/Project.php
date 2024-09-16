<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'description',
        'status',
        'client_id',
        'start_date',
        'end_date',
        'price',
        'url'
    ];

    public function adds()
    {
        return $this->hasMany(Add::class);
    }

    public function clients()
    {
        return $this->belongsTo(Client::class);
    }
}
