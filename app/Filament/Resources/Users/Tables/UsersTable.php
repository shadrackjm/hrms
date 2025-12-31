<?php

namespace App\Filament\Resources\Users\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class UsersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label(__('Name'))
                    ->searchable(),
                TextColumn::make('email')
                    ->label(__('Email'))
                    ->searchable(),
                TextColumn::make('department.name')
                    ->label(__('Department'))
                    ->searchable(),
                TextColumn::make('position.title')
                    ->label(__('Position'))
                    ->searchable(),
                TextColumn::make('employment_type')
                    ->label(__('Employment Type'))
                    ->badge(),
                TextColumn::make('status')
                    ->label(__('Status'))
                    ->badge(),
                TextColumn::make('roles.name')
                    ->label(__('Roles'))
                    ->badge(),
                TextColumn::make('salary')
                    ->label(__('Salary'))
                    ->numeric()
                    ->sortable(),
               TextColumn::make('hire_date')
                    ->label(__('Hire Date'))
                    ->date()
                    ->sortable(),
            ])
            ->filters([
                //
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
