<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Todo extends Model
{
    protected $guarded = [];
    protected $casts = [
        'date' => 'datetime:Y-m-d',
    ];
}
