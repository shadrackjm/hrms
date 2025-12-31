<?php

namespace App\Filament\Hr\Resources\PerformanceReviews\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;

class PerformanceReviewForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make(__('Review Informations'))
                ->columns(2)
                ->schema([
                    Select::make('user_id')
                    ->label(__('Name'))
                    ->relationship('user', 'name')
                    ->searchable()
                    ->preload()
                    ->required(),
                    Select::make('reviewer_id')
                        ->label(__('Reviewer'))
                        ->relationship('reviewer', 'name')
                        ->searchable()
                        ->preload()
                        ->required(),
                    TextInput::make('review_period')
                        ->label(__('Review Period'))
                        ->default(now()->format('Y-m-d'))
                        ->placeholder(__('Select Review Period'))
                        ->required(),
                ]),
                Section::make(__('Perfomance Metrics (1-10)'))
                ->columns(2)
                ->schema([
                    TextInput::make('quality_of_work')
                    ->label(__('Quality of Work'))
                    ->required()
                    ->minValue(1)
                    ->maxValue(10)
                    ->live()
                    ->afterStateUpdated(fn($state, Set $set, Get $get)=> 
                        self::calculateOverallRating($set,$get))
                    ->numeric(),
                    TextInput::make('productivity')
                        ->label(__('Productivity'))
                        ->required()
                        ->minValue(1)
                        ->maxValue(10)
                        ->live()
                        ->afterStateUpdated(fn($state, Set $set, Get $get)=> 
                            self::calculateOverallRating($set,$get))
                        ->numeric(),
                    TextInput::make('communication')
                        ->label(__('Communication'))
                        ->required()
                        ->minValue(1)
                        ->maxValue(10)
                        ->live()
                        ->afterStateUpdated(fn($state, Set $set, Get $get)=> 
                            self::calculateOverallRating($set,$get))
                        ->numeric(),
                    TextInput::make('teamwork')
                        ->label(__('Teamwork'))
                        ->required()
                        ->minValue(1)
                        ->maxValue(10)
                        ->live()
                        ->afterStateUpdated(fn($state, Set $set, Get $get)=> 
                            self::calculateOverallRating($set,$get))
                        ->numeric(),
                    TextInput::make('leadership')
                        ->label(__('Leadership'))
                        ->required()
                        ->minValue(1)
                        ->maxValue(10)
                        ->live()
                        ->afterStateUpdated(fn($state, Set $set, Get $get)=> 
                            self::calculateOverallRating($set,$get))
                        ->numeric(),
                    TextInput::make('overall_rating')
                        ->label(__('Overall Rating'))
                        ->required()
                        ->suffix(' / 10')
                        ->disabled()
                        ->dehydrated()
                        ->numeric(),
                ]),
               
                Section::make(__('Feedback and Goals'))
                ->columns(2)
                ->columnSpanFull()
 
                ->schema([
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
                ])
                
            ]);
    }

    protected static function calculateOverallRating(Set $set, Get $get){
        $qualityOfWork = (int)$get('quality_of_work');
        $productivity = (int)$get('productivity');
        $communication = (int) $get('communication');
        $teamwork = (int) $get('teamwork');
        $leadership = (int) $get('leadership');

        $overallRating = round(($qualityOfWork + $productivity + $communication + $teamwork + $leadership) / 5, 2);
        $set('overall_rating', $overallRating);
    }
}
