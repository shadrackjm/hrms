<?php

namespace App\Filament\Hr\Resources\PerformanceReviews;

use App\Filament\Hr\Resources\PerformanceReviews\Pages\CreatePerformanceReview;
use App\Filament\Hr\Resources\PerformanceReviews\Pages\EditPerformanceReview;
use App\Filament\Hr\Resources\PerformanceReviews\Pages\ListPerformanceReviews;
use App\Filament\Hr\Resources\PerformanceReviews\Schemas\PerformanceReviewForm;
use App\Filament\Hr\Resources\PerformanceReviews\Tables\PerformanceReviewsTable;
use App\Models\PerformanceReview;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class PerformanceReviewResource extends Resource
{
    protected static ?string $model = PerformanceReview::class;

    protected static string | BackedEnum | null $navigationIcon = Heroicon::Star;
    protected static string | UnitEnum | null $navigationGroup = 'Performance Management';
 
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
            'edit' => EditPerformanceReview::route('/{record}/edit'),
        ];
    }
}
