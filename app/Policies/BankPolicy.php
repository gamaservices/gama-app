<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class BankPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user->can('view_any_bank');
    }

    public function view(User $user): bool
    {
        return $user->can('view_bank');
    }

    public function create(User $user): bool
    {
        return $user->can('create_bank');
    }

    public function update(User $user): bool
    {
        return $user->can('update_bank');
    }

    public function delete(User $user): bool
    {
        return $user->can('delete_bank');
    }

    public function deleteAny(User $user): bool
    {
        return $user->can('delete_any_bank');
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
        return $user->can('restore_bank');
    }

    public function restoreAny(User $user): bool
    {
        return $user->can('restore_any_bank');
    }

    public function replicate(User $user): bool
    {
        return $user->can('replicate_bank');
    }

    public function reorder(User $user): bool
    {
        return $user->can('reorder_bank');
    }
}
