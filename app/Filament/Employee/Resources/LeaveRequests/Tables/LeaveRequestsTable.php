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
                    ->searchable(),
                TextColumn::make('leaveType.name')
                    ->searchable(),
                TextColumn::make('start_date')
                    ->date()
                    ->sortable(),
                TextColumn::make('end_date')
                    ->date()
                    ->sortable(),
                TextColumn::make('days')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('status')
                    ->badge(),
                TextColumn::make('approver.name')
                    ->sortable(),
                TextColumn::make('approved_at')
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
