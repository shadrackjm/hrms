<?php

namespace App\Filament\Employee\Resources\PerformanceReviews;

use App\Filament\Employee\Resources\PerformanceReviews\Pages\CreatePerformanceReview;
use App\Filament\Employee\Resources\PerformanceReviews\Pages\EditPerformanceReview;
use App\Filament\Employee\Resources\PerformanceReviews\Pages\ListPerformanceReviews;
use App\Filament\Employee\Resources\PerformanceReviews\Pages\ViewPerformanceReview;
use App\Filament\Employee\Resources\PerformanceReviews\Schemas\PerformanceReviewForm;
use App\Filament\Employee\Resources\PerformanceReviews\Schemas\PerformanceReviewInfolist;
use App\Filament\Employee\Resources\PerformanceReviews\Tables\PerformanceReviewsTable;
use App\Models\PerformanceReview;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class PerformanceReviewResource extends Resource
{
    protected static ?string $model = PerformanceReview::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;
 
    public static function getNavigationLabel(): string
    {
        return __('Performance Reviews');
    }
 
    public static function getPluralModelLabel(): string
    {
        return __('Performance Reviews');
    }
 
    public static function getModelLabel(): string
    {
        return __('Performance Review');
    }

    public static function form(Schema $schema): Schema
    {
        return PerformanceReviewForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return PerformanceReviewInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return PerformanceReviewsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListPerformanceReviews::route('/'),
            'create' => CreatePerformanceReview::route('/create'),
            'view' => ViewPerformanceReview::route('/{record}'),
            'edit' => EditPerformanceReview::route('/{record}/edit'),
        ];
    }
}
