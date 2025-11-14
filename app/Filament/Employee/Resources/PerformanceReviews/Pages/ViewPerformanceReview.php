<?php

namespace App\Filament\Employee\Resources\PerformanceReviews\Pages;

use App\Filament\Employee\Resources\PerformanceReviews\PerformanceReviewResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewPerformanceReview extends ViewRecord
{
    protected static string $resource = PerformanceReviewResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
