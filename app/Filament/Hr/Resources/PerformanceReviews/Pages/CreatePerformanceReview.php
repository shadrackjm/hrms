<?php

namespace App\Filament\Hr\Resources\PerformanceReviews\Pages;

use App\Filament\Hr\Resources\PerformanceReviews\PerformanceReviewResource;
use Filament\Resources\Pages\CreateRecord;

class CreatePerformanceReview extends CreateRecord
{
    protected static string $resource = PerformanceReviewResource::class;
}
