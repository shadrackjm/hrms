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
                    ->label(__('Name'))
                    ->relationship('user', 'name')
                    ->required(),
                Select::make('reviewer_id')
                    ->label(__('Reviewer'))
                    ->relationship('reviewer', 'name')
                    ->required(),
                TextInput::make('review_period')
                    ->label(__('Review Period'))
                    ->required(),
                TextInput::make('quality_of_work')
                    ->label(__('Quality of Work'))
                    ->required()
                    ->numeric(),
                TextInput::make('productivity')
                    ->label(__('Productivity'))
                    ->required()
                    ->numeric(),
                TextInput::make('communication')
                    ->label(__('Communication'))
                    ->required()
                    ->numeric(),
                TextInput::make('teamwork')
                    ->label(__('Teamwork'))
                    ->required()
                    ->numeric(),
                TextInput::make('leadership')
                    ->label(__('Leadership'))
                    ->required()
                    ->numeric(),
                TextInput::make('overall_rating')
                    ->label(__('Overall Rating'))
                    ->required()
                    ->numeric(),
                Textarea::make('strengths')
                    ->label(__('Strengths'))
                    ->default(null)
                    ->columnSpanFull(),
                Textarea::make('areas_for_improvement')
                    ->label(__('Areas for Improvement'))
                    ->default(null)
                    ->columnSpanFull(),
                Textarea::make('goals')
                    ->label(__('Goals'))
                    ->default(null)
                    ->columnSpanFull(),
                Textarea::make('comments')
                    ->label(__('Comments'))
                    ->default(null)
                    ->columnSpanFull(),
            ]);
    }
}
