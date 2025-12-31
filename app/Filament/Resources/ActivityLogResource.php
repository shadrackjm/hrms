<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ActivityLogResource\Pages;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Spatie\Activitylog\Models\Activity;
use Filament\Tables\Columns\TextColumn;
use Filament\Actions\ViewAction;
use BackedEnum;
use UnitEnum;

class ActivityLogResource extends Resource
{
    protected static ?string $model = Activity::class;
    
    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-list-bullet';

    protected static string | UnitEnum | null $navigationGroup = 'User Management';

    public static function getNavigationLabel(): string
    {
        return __('Laporan Aktivitas');
    }

    public static function getPluralModelLabel(): string
    {
        return __('Laporan Aktivitas');
    }

    public static function getModelLabel(): string
    {
        return __('Laporan Aktivitas');
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('created_at')
                    ->label(__('Waktu'))
                    ->dateTime()
                    ->sortable(),
                TextColumn::make('causer.name')
                    ->label(__('Pengguna'))
                    ->searchable(),
                TextColumn::make('description')
                    ->label(__('Aktivitas'))
                    ->formatStateUsing(fn ($state) => __($state))
                    ->searchable(),
                TextColumn::make('subject_type')
                    ->label(__('Modul'))
                    ->formatStateUsing(fn ($state) => str_replace('App\\Models\\', '', $state)),
                TextColumn::make('properties.ip')
                    ->label(__('IP Address')),
                TextColumn::make('event')
                    ->label(__('Kejadian'))
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'created' => 'success',
                        'updated' => 'warning',
                        'deleted' => 'danger',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn ($state) => __($state)),
            ])
            ->filters([
                //
            ])
            ->actions([
                ViewAction::make(),
            ])
            ->bulkActions([
                //
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListActivityLogs::route('/'),
        ];
    }
}
