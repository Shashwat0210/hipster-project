<?php

use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('presence.online', function($user) {
    return [
        'id' => $user->id,
        'name' => $user->name,
        'type' => $user instanceof \App\Models\Admin ? 'admin' : 'customer',
    ];
});