<?php

use Illuminate\Support\Facades\Broadcast;

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

use App\Models\Group;

Broadcast::channel('group.{groupId}', function ($user, $groupId) {
    $group = Group::find($groupId);
    if (!$group) {
        \Log::error("Group not found: $groupId");
        return false;
    }
    if (!$group->users->contains($user)) {
        \Log::error("User {$user->id} not part of group $groupId");
        return false;
    }
    return true;
});
