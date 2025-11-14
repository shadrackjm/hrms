<?php

namespace App\Filament\Employee\Resources\PerformanceReviews\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class PerformanceReviewInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('user.name')
                    ->label('User'),
                TextEntry::make('reviewer.name')
                    ->label('Reviewer'),
                TextEntry::make('review_period'),
                TextEntry::make('quality_of_work')
                    ->numeric(),
                TextEntry::make('productivity')
                    ->numeric(),
                TextEntry::make('communication')
                    ->numeric(),
                TextEntry::make('teamwork')
                    ->numeric(),
                TextEntry::make('leadership')
                    ->numeric(),
                TextEntry::make('overall_rating')
                    ->numeric(),
                TextEntry::make('strengths')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('areas_for_improvement')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('goals')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('comments')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),
            ]);
    }
}
