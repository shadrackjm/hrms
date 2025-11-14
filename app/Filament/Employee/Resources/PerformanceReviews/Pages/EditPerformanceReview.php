<?php

namespace App\Filament\Employee\Resources\PerformanceReviews\Pages;

use App\Filament\Employee\Resources\PerformanceReviews\PerformanceReviewResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditPerformanceReview extends EditRecord
{
    protected static string $resource = PerformanceReviewResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
