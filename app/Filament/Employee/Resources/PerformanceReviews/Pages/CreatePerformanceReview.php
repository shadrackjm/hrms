<?php

namespace App\Filament\Employee\Resources\PerformanceReviews\Pages;

use App\Filament\Employee\Resources\PerformanceReviews\PerformanceReviewResource;
use Filament\Resources\Pages\CreateRecord;

class CreatePerformanceReview extends CreateRecord
{
    protected static string $resource = PerformanceReviewResource::class;
}
