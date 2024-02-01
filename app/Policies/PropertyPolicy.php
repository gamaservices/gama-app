<?php

namespace App\Policies;

use App\Models\Property;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class PropertyPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user->can('view_any_property');
    }

    public function view(User $user, Property $property): bool
    {
        return $user->can('view_property');
    }

    public function create(User $user): bool
    {
        return $user->can('create_property');
    }

    public function update(User $user, Property $property): bool
    {
        return $user->can('update_property');
    }

    public function delete(User $user, Property $property): bool
    {
        return $user->can('delete_property');
    }

    public function deleteAny(User $user): bool
    {
        return $user->can('delete_any_property');
    }

    public function forceDelete(User $user, Property $property): bool
    {
        return false;
    }

    public function forceDeleteAny(User $user): bool
    {
        return false;
    }

    public function restore(User $user, Property $property): bool
    {
        return $user->can('restore_property');
    }

    public function restoreAny(User $user): bool
    {
        return $user->can('restore_any_property');
    }

    public function replicate(User $user, Property $property): bool
    {
        return $user->can('replicate_property');
    }

    public function reorder(User $user): bool
    {
        return $user->can('reorder_property');
    }
}
