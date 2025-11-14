<?php

namespace App\Filament\Employee\Resources\PerformanceReviews\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class PerformanceReviewForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('user_id')
                    ->relationship('user', 'name')
                    ->required(),
                Select::make('reviewer_id')
                    ->relationship('reviewer', 'name')
                    ->required(),
                TextInput::make('review_period')
                    ->required(),
                TextInput::make('quality_of_work')
                    ->required()
                    ->numeric(),
                TextInput::make('productivity')
                    ->required()
                    ->numeric(),
                TextInput::make('communication')
                    ->required()
                    ->numeric(),
                TextInput::make('teamwork')
                    ->required()
                    ->numeric(),
                TextInput::make('leadership')
                    ->required()
                    ->numeric(),
                TextInput::make('overall_rating')
                    ->required()
                    ->numeric(),
                Textarea::make('strengths')
                    ->default(null)
                    ->columnSpanFull(),
                Textarea::make('areas_for_improvement')
                    ->default(null)
                    ->columnSpanFull(),
                Textarea::make('goals')
                    ->default(null)
                    ->columnSpanFull(),
                Textarea::make('comments')
                    ->default(null)
                    ->columnSpanFull(),
            ]);
    }
}
