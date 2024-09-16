<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use SebastianBergmann\CodeCoverage\Report\Xml\Project;

class Add extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_id',
        'type',
        'title',
        'description',
        'expense_amount',
        'file_path',
        'added_by'
    ];

    public function projects()
    {
        return $this->belongsTo(Project::class);
    }

    public function addedBy()
    {
        return $this->belongsTo(User::class, 'added_by');
    }

    public function isFail()
    {
        return $this->type === 'file';
    }

    public function isLink()
    {
        return $this->type === 'link';
    }

    public function isExpense()
    {
        return $this->type === 'expense';
    }

    public function isNote()
    {
        return $this->type === 'note';
    }
}
