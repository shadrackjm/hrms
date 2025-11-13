<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\PerformanceReview;
use Illuminate\Auth\Access\HandlesAuthorization;

class PerformanceReviewPolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:PerformanceReview');
    }

    public function view(AuthUser $authUser, PerformanceReview $performanceReview): bool
    {
        return $authUser->can('View:PerformanceReview');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:PerformanceReview');
    }

    public function update(AuthUser $authUser, PerformanceReview $performanceReview): bool
    {
        return $authUser->can('Update:PerformanceReview');
    }

    public function delete(AuthUser $authUser, PerformanceReview $performanceReview): bool
    {
        return $authUser->can('Delete:PerformanceReview');
    }

    public function restore(AuthUser $authUser, PerformanceReview $performanceReview): bool
    {
        return $authUser->can('Restore:PerformanceReview');
    }

    public function forceDelete(AuthUser $authUser, PerformanceReview $performanceReview): bool
    {
        return $authUser->can('ForceDelete:PerformanceReview');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:PerformanceReview');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:PerformanceReview');
    }

    public function replicate(AuthUser $authUser, PerformanceReview $performanceReview): bool
    {
        return $authUser->can('Replicate:PerformanceReview');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:PerformanceReview');
    }

}