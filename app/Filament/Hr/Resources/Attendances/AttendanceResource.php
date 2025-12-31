<?php

namespace App\Filament\Hr\Resources\Attendances;

use App\Filament\Hr\Resources\Attendances\Pages\CreateAttendance;
use App\Filament\Hr\Resources\Attendances\Pages\EditAttendance;
use App\Filament\Hr\Resources\Attendances\Pages\ListAttendances;
use App\Filament\Hr\Resources\Attendances\Schemas\AttendanceForm;
use App\Filament\Hr\Resources\Attendances\Tables\AttendancesTable;
use App\Models\Attendance;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class AttendanceResource extends Resource
{
    protected static ?string $model = Attendance::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::Clock;
 
    public static function getNavigationLabel(): string
    {
        return __('Attendances');
    }
 
    public static function getPluralModelLabel(): string
    {
        return __('Attendances');
    }
 
    public static function getModelLabel(): string
    {
        return __('Attendance');
    }

    public static function form(Schema $schema): Schema
    {
        return AttendanceForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return AttendancesTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListAttendances::route('/'),
            'create' => CreateAttendance::route('/create'),
            'edit' => EditAttendance::route('/{record}/edit'),
        ];
    }
}
