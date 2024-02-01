<?php

namespace App\Policies;

use App\Models\PublicService;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class PublicServicePolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user->can('view_any_public::service');
    }

    public function view(User $user, PublicService $publicService): bool
    {
        return $user->can('view_public::service');
    }

    public function create(User $user): bool
    {
        return $user->can('create_public::service');
    }

    public function update(User $user, PublicService $publicService): bool
    {
        return $user->can('update_public::service');
    }

    public function delete(User $user, PublicService $publicService): bool
    {
        return $user->can('delete_public::service');
    }

    public function deleteAny(User $user): bool
    {
        return $user->can('delete_any_public::service');
    }

    public function forceDelete(User $user, PublicService $publicService): bool
    {
        return false;
    }

    public function forceDeleteAny(User $user): bool
    {
        return false;
    }

    public function restore(User $user, PublicService $publicService): bool
    {
        return $user->can('restore_public::service');
    }

    public function restoreAny(User $user): bool
    {
        return $user->can('restore_any_public::service');
    }

    public function replicate(User $user, PublicService $publicService): bool
    {
        return $user->can('replicate_public::service');
    }

    public function reorder(User $user): bool
    {
        return $user->can('reorder_public::service');
    }
}
