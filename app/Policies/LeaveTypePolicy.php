<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\LeaveType;
use Illuminate\Auth\Access\HandlesAuthorization;

class LeaveTypePolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:LeaveType');
    }

    public function view(AuthUser $authUser, LeaveType $leaveType): bool
    {
        return $authUser->can('View:LeaveType');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:LeaveType');
    }

    public function update(AuthUser $authUser, LeaveType $leaveType): bool
    {
        return $authUser->can('Update:LeaveType');
    }

    public function delete(AuthUser $authUser, LeaveType $leaveType): bool
    {
        return $authUser->can('Delete:LeaveType');
    }

    public function restore(AuthUser $authUser, LeaveType $leaveType): bool
    {
        return $authUser->can('Restore:LeaveType');
    }

    public function forceDelete(AuthUser $authUser, LeaveType $leaveType): bool
    {
        return $authUser->can('ForceDelete:LeaveType');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:LeaveType');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:LeaveType');
    }

    public function replicate(AuthUser $authUser, LeaveType $leaveType): bool
    {
        return $authUser->can('Replicate:LeaveType');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:LeaveType');
    }

}