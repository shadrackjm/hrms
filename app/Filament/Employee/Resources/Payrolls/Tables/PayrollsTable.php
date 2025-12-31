<?php

namespace App\Filament\Employee\Resources\Payrolls\Tables;

use Filament\Tables\Table;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Builder;

class PayrollsTable
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
                TextColumn::make('month')
                    ->label(__('Month'))
                    ->searchable(),
                TextColumn::make('year')
                    ->label(__('Year'))
                    ->numeric()
                    ->sortable(),
                TextColumn::make('basic_salary')
                    ->label(__('Basic Salary'))
                    ->numeric()
                    ->formatStateUsing(fn ($state) => 'Rp ' . number_format($state, 0, ",", "."))
                    ->sortable(),
                TextColumn::make('allowances')
                    ->label(__('Allowances'))
                    ->numeric()
                    ->formatStateUsing(fn ($state) => 'Rp ' . number_format($state, 0, ",", "."))
                    ->sortable(),
                TextColumn::make('deductions')
                    ->label(__('Deductions'))
                    ->numeric()
                    ->formatStateUsing(fn ($state) => 'Rp ' . number_format($state, 0, ",", "."))
                    ->sortable(),
                TextColumn::make('bonus')
                    ->label(__('Bonus'))
                    ->numeric()
                    ->formatStateUsing(fn ($state) => 'Rp ' . number_format($state, 0, ",", "."))
                    ->sortable(),
                TextColumn::make('net_salary')
                    ->label(__('Net Salary'))
                    ->numeric()
                    ->formatStateUsing(fn ($state) => 'Rp ' . number_format($state, 0, ",", "."))
                    ->sortable(),
                TextColumn::make('status')
                    ->label(__('Status'))
                    ->badge(),
                TextColumn::make('paid_at')
                    ->label(__('Paid At'))
                    ->date()
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
