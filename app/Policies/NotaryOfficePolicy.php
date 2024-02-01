<?php

namespace App\Policies;

use App\Models\NotaryOffice;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class NotaryOfficePolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user->can('view_any_notary::office');
    }

    public function view(User $user, NotaryOffice $notaryOffice): bool
    {
        return $user->can('view_notary::office');
    }

    public function create(User $user): bool
    {
        return $user->can('create_notary::office');
    }

    public function update(User $user, NotaryOffice $notaryOffice): bool
    {
        return $user->can('update_notary::office');
    }

    public function delete(User $user, NotaryOffice $notaryOffice): bool
    {
        return $user->can('delete_notary::office');
    }

    public function deleteAny(User $user): bool
    {
        return $user->can('delete_any_notary::office');
    }

    public function forceDelete(User $user, NotaryOffice $notaryOffice): bool
    {
        return $user->can('force_delete_notary::office');
    }

    public function forceDeleteAny(User $user): bool
    {
        return $user->can('force_delete_any_notary::office');
    }

    public function restore(User $user, NotaryOffice $notaryOffice): bool
    {
        return $user->can('restore_notary::office');
    }

    public function restoreAny(User $user): bool
    {
        return $user->can('restore_any_notary::office');
    }

    public function replicate(User $user, NotaryOffice $notaryOffice): bool
    {
        return $user->can('replicate_notary::office');
    }

    public function reorder(User $user): bool
    {
        return $user->can('reorder_notary::office');
    }
}
