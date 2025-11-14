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
                    ->searchable(),
                TextColumn::make('reviewer.name')
                    ->searchable(),
                TextColumn::make('review_period')
                    ->searchable(),
                TextColumn::make('quality_of_work')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('productivity')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('communication')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('teamwork')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('leadership')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('overall_rating')
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
