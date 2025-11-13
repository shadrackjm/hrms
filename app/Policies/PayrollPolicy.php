<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\Payroll;
use Illuminate\Auth\Access\HandlesAuthorization;

class PayrollPolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:Payroll');
    }

    public function view(AuthUser $authUser, Payroll $payroll): bool
    {
        return $authUser->can('View:Payroll');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:Payroll');
    }

    public function update(AuthUser $authUser, Payroll $payroll): bool
    {
        return $authUser->can('Update:Payroll');
    }

    public function delete(AuthUser $authUser, Payroll $payroll): bool
    {
        return $authUser->can('Delete:Payroll');
    }

    public function restore(AuthUser $authUser, Payroll $payroll): bool
    {
        return $authUser->can('Restore:Payroll');
    }

    public function forceDelete(AuthUser $authUser, Payroll $payroll): bool
    {
        return $authUser->can('ForceDelete:Payroll');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:Payroll');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:Payroll');
    }

    public function replicate(AuthUser $authUser, Payroll $payroll): bool
    {
        return $authUser->can('Replicate:Payroll');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:Payroll');
    }

}