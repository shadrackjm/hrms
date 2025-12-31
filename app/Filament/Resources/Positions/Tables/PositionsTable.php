<?php

namespace App\Filament\Resources\Positions\Tables;

use Filament\Tables\Table;
use PhpParser\Node\Stmt\Label;
use Filament\Actions\EditAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Tables\Columns\TextColumn;

class PositionsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')
                    ->label(__('Title'))
                    ->searchable(),
                TextColumn::make('department.name')
                    ->label(__('Department'))
                    ->searchable(),
                TextColumn::make('min_salary')
                    ->label(__('Min Salary'))
                    ->numeric()
                    ->formatStateUsing(fn ($state) => 'Rp ' . number_format($state, 0, ",", "."))
                    ->sortable(),
                TextColumn::make('max_salary')
                    ->label(__('Max Salary'))
                    ->numeric()
                    ->formatStateUsing(fn ($state) => 'Rp ' . number_format($state, 0, ",", "."))
                    ->sortable(),
                TextColumn::make('employees_count')
                    ->counts('employees')
                    ->label(__('Employees')),
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
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
