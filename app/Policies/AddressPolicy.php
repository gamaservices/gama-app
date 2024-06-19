<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class AddressPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user->can('view_any_address');
    }

    public function view(User $user): bool
    {
        return $user->can('view_address');
    }

    public function create(User $user): bool
    {
        return $user->can('create_address');
    }

    public function update(User $user): bool
    {
        return $user->can('update_address');
    }

    public function delete(User $user): bool
    {
        return $user->can('delete_address');
    }

    public function deleteAny(User $user): bool
    {
        return $user->can('delete_any_address');
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
        return $user->can('restore_address');
    }

    public function restoreAny(User $user): bool
    {
        return $user->can('restore_any_address');
    }

    public function replicate(User $user): bool
    {
        return $user->can('replicate_address');
    }

    public function reorder(User $user): bool
    {
        return $user->can('reorder_address');
    }
}
