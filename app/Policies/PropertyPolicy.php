<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class PropertyPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user->can('view_any_property');
    }

    public function view(User $user): bool
    {
        return $user->can('view_property');
    }

    public function create(User $user): bool
    {
        return $user->can('create_property');
    }

    public function update(User $user): bool
    {
        return $user->can('update_property');
    }

    public function delete(User $user): bool
    {
        return $user->can('delete_property');
    }

    public function deleteAny(User $user): bool
    {
        return $user->can('delete_any_property');
    }

    public function forceDelete(): bool
    {
        return false;
    }

    public function forceDeleteAny(): bool
    {
        return false;
    }

    public function restore(User $user): bool
    {
        return $user->can('restore_property');
    }

    public function restoreAny(User $user): bool
    {
        return $user->can('restore_any_property');
    }

    public function replicate(User $user): bool
    {
        return $user->can('replicate_property');
    }

    public function reorder(User $user): bool
    {
        return $user->can('reorder_property');
    }
}
