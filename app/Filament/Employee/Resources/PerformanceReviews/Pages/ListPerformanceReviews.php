<?php

namespace App\Filament\Employee\Resources\PerformanceReviews\Pages;

use App\Filament\Employee\Resources\PerformanceReviews\PerformanceReviewResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListPerformanceReviews extends ListRecords
{
    protected static string $resource = PerformanceReviewResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
