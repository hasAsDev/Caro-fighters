<?php

use Illuminate\Support\Facades\Broadcast;
use App\Models\User;

Broadcast::channel('channel_for_fighter_{fighter_id}', function (User $user, int $fighter_id) {
    return $user->id === $fighter_id;
});

Broadcast::channel('channel_for_battleground_{battleground_id}', function (User $user) {
    return $user;
});
