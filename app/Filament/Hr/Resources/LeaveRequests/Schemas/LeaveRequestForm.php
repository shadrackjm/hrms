<?php

namespace App\Filament\Hr\Resources\LeaveRequests\Schemas;

use Carbon\Carbon;
use Filament\Schemas\Schema;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\DateTimePicker;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;

class LeaveRequestForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('user_id')
                    ->relationship('user', 'name')
                    ->searchable()
                    ->preload()
                    ->required(),
                Select::make('leave_type_id')
                    ->relationship('leaveType', 'name')
                    ->preload()
                    ->searchable()
                    ->required(),
                DatePicker::make('start_date')
                    ->live()
                    ->required()
                    ->afterStateUpdated(fn($state, Set $set, Get $get)=> 
                        self::calculateDays($set,$get)),
                DatePicker::make('end_date')
                    ->live()
                    ->afterStateUpdated(fn($state, Set $set, Get $get)=> 
                        self::calculateDays($set,$get))
                    ->required(),
                TextInput::make('days')
                    ->required()
                    ->disabled()
                    ->dehydrated()
                    ->numeric(),
                Textarea::make('reason')
                    ->required()
                    ->columnSpanFull(),
                Select::make('status')
                    ->options(['pending' => 'Pending', 'approved' => 'Approved', 'rejected' => 'Rejected'])
                    ->default('pending')
                    ->live()
                    ->required(),
                DateTimePicker::make('approved_at'),
                Textarea::make('rejection_reason')
                    ->default(null)
                    ->columnSpanFull()
                    ->visible(fn(Get $get) => $get('status') === 'rejected'),
            ]);
    }

    protected static function calculateDays(Set $set, Get $get){
        $start = $get('start_date');
        $end = $get('end_date');

        if ($start && $end) {
            $startDate = Carbon::parse($start);
            $endDate = Carbon::parse($end);
            $days = $startDate->diffInDays($endDate) + 1;

            $set('days', $days);
        }
    }
}
