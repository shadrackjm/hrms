<?php

namespace App\Filament\Employee\Resources\Attendances;

use App\Filament\Employee\Resources\Attendances\Pages\CreateAttendance;
use App\Filament\Employee\Resources\Attendances\Pages\EditAttendance;
use App\Filament\Employee\Resources\Attendances\Pages\ListAttendances;
use App\Filament\Employee\Resources\Attendances\Pages\ViewAttendance;
use App\Filament\Employee\Resources\Attendances\Schemas\AttendanceForm;
use App\Filament\Employee\Resources\Attendances\Schemas\AttendanceInfolist;
use App\Filament\Employee\Resources\Attendances\Tables\AttendancesTable;
use App\Models\Attendance;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use BackedEnum;
use UnitEnum;
class AttendanceResource extends Resource
{
    protected static ?string $model = Attendance::class;

    protected static string| BackedEnum|null $navigationIcon = Heroicon::Clock;
    protected static string | UnitEnum | null $navigationGroup = 'Attendances';

    public static function form(Schema $schema): Schema
    {
        return AttendanceForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return AttendanceInfolist::configure($schema);
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
            'view' => ViewAttendance::route('/{record}'),
            'edit' => EditAttendance::route('/{record}/edit'),
        ];
    }
}
