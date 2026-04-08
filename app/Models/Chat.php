<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    protected $fillable = [
        'user_id',
        'message',
        'is_admin'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
