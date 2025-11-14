<?php

namespace App\Filament\Employee\Resources\LeaveRequests;

use App\Filament\Employee\Resources\LeaveRequests\Pages\CreateLeaveRequest;
use App\Filament\Employee\Resources\LeaveRequests\Pages\EditLeaveRequest;
use App\Filament\Employee\Resources\LeaveRequests\Pages\ListLeaveRequests;
use App\Filament\Employee\Resources\LeaveRequests\Pages\ViewLeaveRequest;
use App\Filament\Employee\Resources\LeaveRequests\Schemas\LeaveRequestForm;
use App\Filament\Employee\Resources\LeaveRequests\Schemas\LeaveRequestInfolist;
use App\Filament\Employee\Resources\LeaveRequests\Tables\LeaveRequestsTable;
use App\Models\LeaveRequest;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class LeaveRequestResource extends Resource
{
    protected static ?string $model = LeaveRequest::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::CalendarDays;
    protected static ?string $navigationLabel = 'My Leave Requests';
    public static function form(Schema $schema): Schema
    {
        return LeaveRequestForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return LeaveRequestInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return LeaveRequestsTable::configure($table);
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
            'index' => ListLeaveRequests::route('/'),
            'create' => CreateLeaveRequest::route('/create'),
            'view' => ViewLeaveRequest::route('/{record}'),
            'edit' => EditLeaveRequest::route('/{record}/edit'),
        ];
    }
}
