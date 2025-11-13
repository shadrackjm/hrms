<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\Position;
use Illuminate\Auth\Access\HandlesAuthorization;

class PositionPolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:Position');
    }

    public function view(AuthUser $authUser, Position $position): bool
    {
        return $authUser->can('View:Position');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:Position');
    }

    public function update(AuthUser $authUser, Position $position): bool
    {
        return $authUser->can('Update:Position');
    }

    public function delete(AuthUser $authUser, Position $position): bool
    {
        return $authUser->can('Delete:Position');
    }

    public function restore(AuthUser $authUser, Position $position): bool
    {
        return $authUser->can('Restore:Position');
    }

    public function forceDelete(AuthUser $authUser, Position $position): bool
    {
        return $authUser->can('ForceDelete:Position');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:Position');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:Position');
    }

    public function replicate(AuthUser $authUser, Position $position): bool
    {
        return $authUser->can('Replicate:Position');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:Position');
    }

}