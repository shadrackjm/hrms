<?php

namespace App\Filament\Hr\Resources\PerformanceReviews\Tables;

use Filament\Tables\Table;
use Filament\Actions\EditAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;

class PerformanceReviewsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user.name')
                    ->label(__('Name'))
                    ->searchable(),
                    TextColumn::make('user.employee_id')
                    ->label(__('Employee Code'))
                    ->searchable(),
                TextColumn::make('reviewer.name')
                    ->label(__('Reviewer'))
                    ->searchable(),
                TextColumn::make('review_period')
                    ->label(__('Review Period'))
                    ->searchable(),
                
                TextColumn::make('overall_rating')
                    ->label(__('Overall Rating'))
                    ->numeric()
                    ->badge()
                    ->suffix(' / 10')
                    ->colors([
                        'danger' => fn($state)=> $state < 5,
                        'warning' => fn($state)=> $state >= 5 && $state < 8,
                        'success' => fn($state)=> $state >= 8,
                    ])
                    ->sortable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('user_id')
                ->relationship('user', 'name')
                ->searchable()
                ->preload(),
                SelectFilter::make('reviewer_id')
                ->relationship('reviewer', 'name')
                ->searchable()
                ->preload(),
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
