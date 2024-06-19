<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class PropertyAdminPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user->can('view_any_property::admin');
    }

    public function view(User $user): bool
    {
        return $user->can('view_property::admin');
    }

    public function create(User $user): bool
    {
        return $user->can('create_property::admin');
    }

    public function update(User $user): bool
    {
        return $user->can('update_property::admin');
    }

    public function delete(User $user): bool
    {
        return $user->can('delete_property::admin');
    }

    public function deleteAny(User $user): bool
    {
        return $user->can('delete_any_property::admin');
    }

    public function forceDelete(User $user): bool
    {
        return $user->can('force_delete_property::admin');
    }

    public function forceDeleteAny(User $user): bool
    {
        return $user->can('force_delete_any_property::admin');
    }

    public function restore(User $user): bool
    {
        return $user->can('restore_property::admin');
    }

    public function restoreAny(User $user): bool
    {
        return $user->can('restore_any_property::admin');
    }

    public function replicate(User $user): bool
    {
        return $user->can('replicate_property::admin');
    }

    public function reorder(User $user): bool
    {
        return $user->can('reorder_property::admin');
    }
}
