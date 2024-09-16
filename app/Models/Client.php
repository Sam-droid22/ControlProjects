<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'id_type',
        'id_number',
        'email',
        'phone',
        'address'
    ];

    public function ptojects()
    {
        return $this->hasMany(Project::class);
    }
}
