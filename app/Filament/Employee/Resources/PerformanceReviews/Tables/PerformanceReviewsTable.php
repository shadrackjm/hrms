<?php

namespace App\Filament\Employee\Resources\PerformanceReviews\Tables;

use Filament\Tables\Table;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Builder;

class PerformanceReviewsTable
{
    public static function configure(Table $table): Table
    {
        return $table
        ->modifyQueryUsing(function (Builder $query) {
            return $query->where('user_id', auth()->user()->id);
        })
            ->columns([
                TextColumn::make('user.name')
                    ->label(__('Name'))
                    ->searchable(),
                TextColumn::make('reviewer.name')
                    ->label(__('Reviewer'))
                    ->searchable(),
                TextColumn::make('review_period')
                    ->label(__('Review Period'))
                    ->searchable(),
                TextColumn::make('quality_of_work')
                    ->label(__('Quality of Work'))
                    ->numeric()
                    ->sortable(),
                TextColumn::make('productivity')
                    ->label(__('Productivity'))
                    ->numeric()
                    ->sortable(),
                TextColumn::make('communication')
                    ->label(__('Communication'))
                    ->numeric()
                    ->sortable(),
                TextColumn::make('teamwork')
                    ->label(__('Teamwork'))
                    ->numeric()
                    ->sortable(),
                TextColumn::make('leadership')
                    ->label(__('Leadership'))
                    ->numeric()
                    ->sortable(),
                TextColumn::make('overall_rating')
                    ->label(__('Overall Rating'))
                    ->badge()
                    ->colors([
                        'danger' => fn($state) => $state < 5,
                        'warning' => fn($state) => $state >= 5 && $state < 7,
                        'success' => fn($state) =>  $state >= 7,
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
                //
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    // DeleteBulkAction::make(),
                ]),
            ]);
    }
}
