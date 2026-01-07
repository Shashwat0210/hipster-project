<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserPresence extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'user_type',
        'user_id',
        'is_online',
        'last_seen_at',
    ];
}
