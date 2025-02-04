<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{

    protected $hidden=[
        'user_id',
        'updated_at	'
    ];

    protected $fillable = [
        'user_id',
        'title',
        'description',
        'status',
        'due_date',
    ];


    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
