<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_id',
        'task',
        'description',
        'assigned_to',
        'status',
        'due_date'
    ];

    public function projects()
    {
        return $this->belongsTo(Project::class);
    }

    public function assignedTo(){
        return $this->belongsTo(User::class, 'assigned_to');
    }
}

