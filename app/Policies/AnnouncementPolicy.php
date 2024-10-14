<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Announcement;
use Illuminate\Auth\Access\HandlesAuthorization;

class AnnouncementPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->can('view_any_announcement');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Announcement $announcement): bool
    {
        return $user->can('view_announcement');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can('create_announcement');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Announcement $announcement): bool
    {
        return $user->can('update_announcement');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Announcement $announcement): bool
    {
        return $user->can('delete_announcement');
    }

    /**
     * Determine whether the user can bulk delete.
     */
    public function deleteAny(User $user): bool
{
    return $user->can('delete_any_announcement');
}

    /**
     * Determine whether the user can permanently delete.
     */
    public function forceDeleteAny(User $user): bool
{
    return $user->can('force_delete_any_announcement');
}

public function restore(User $user, Announcement $announcement): bool
{
    return $user->can('restore_announcement');
}

public function restoreAny(User $user): bool
{
    return $user->can('restore_any_announcement');
}

public function replicate(User $user, Announcement $announcement): bool
{
    return $user->can('replicate_announcement');
}

public function reorder(User $user): bool
{
    return $user->can('reorder_announcements');
}
}
