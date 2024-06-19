<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class InsurancePolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user->can('view_any_insurance');
    }

    public function view(User $user): bool
    {
        return $user->can('view_insurance');
    }

    public function create(User $user): bool
    {
        return $user->can('create_insurance');
    }

    public function update(User $user): bool
    {
        return $user->can('update_insurance');
    }

    public function delete(User $user): bool
    {
        return $user->can('delete_insurance');
    }

    public function deleteAny(User $user): bool
    {
        return $user->can('delete_any_insurance');
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
        return $user->can('restore_insurance');
    }

    public function restoreAny(User $user): bool
    {
        return $user->can('restore_any_insurance');
    }

    public function replicate(User $user): bool
    {
        return $user->can('replicate_insurance');
    }

    public function reorder(User $user): bool
    {
        return $user->can('reorder_insurance');
    }
}
