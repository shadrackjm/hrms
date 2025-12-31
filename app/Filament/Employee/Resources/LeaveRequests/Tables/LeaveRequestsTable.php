<?php

namespace App\Filament\Employee\Resources\LeaveRequests\Tables;

use Filament\Tables\Table;
use App\Models\LeaveRequest;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Builder;

class LeaveRequestsTable
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
                TextColumn::make('leaveType.name')
                    ->label(__('Leave Type'))
                    ->searchable(),
                TextColumn::make('start_date')
                    ->label(__('Start Date'))
                    ->date()
                    ->sortable(),
                TextColumn::make('end_date')
                    ->label(__('End Date'))
                    ->date()
                    ->sortable(),
                TextColumn::make('days')
                    ->label(__('Days'))
                    ->numeric()
                    ->sortable(),
                TextColumn::make('status')
                    ->label(__('Status'))
                    ->badge(),
                TextColumn::make('approver.name')
                    ->label(__('Approver'))
                    ->sortable(),
                TextColumn::make('approved_at')
                    ->label(__('Approved At'))
                    ->dateTime()
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
                EditAction::make()
                ->visible(fn(LeaveRequest $record) => $record->status == 'pending'),
                DeleteAction::make()
                ->visible(fn(LeaveRequest $record) => $record->status == 'pending'),

            ])
            ->toolbarActions([
                BulkActionGroup::make([
                ]),
            ]);
    }
}
