<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model;

class Todo extends Model
{
    use HasFactory;

    protected $dates = [
        'due_date'
    ];

    public function user()
    {
        $this->belongsTo(User::class);
    }
}
