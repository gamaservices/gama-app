<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Spatie\Permission\Models\Role;

class RolePolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user->can('view_any_role');
    }

    public function view(User $user, Role $role): bool
    {
        return $user->can('view_role');
    }

    public function create(User $user): bool
    {
        return $user->can('create_role');
    }

    public function update(User $user, Role $role): bool
    {
        return $user->can('update_role');
    }

    public function delete(User $user, Role $role): bool
    {
        return $user->can('delete_role');
    }

    public function deleteAny(User $user): bool
    {
        return $user->can('delete_any_role');
    }

    public function forceDelete(User $user, Role $role): bool
    {
        return false;
    }

    public function forceDeleteAny(User $user): bool
    {
        return false;
    }

    public function restore(User $user, Role $role): bool
    {
        return $user->can('restore_role');
    }

    public function restoreAny(User $user): bool
    {
        return $user->can('restore_any_role');
    }

    public function replicate(User $user, Role $role): bool
    {
        return $user->can('replicate_role');
    }

    public function reorder(User $user): bool
    {
        return $user->can('reorder_role');
    }
}
