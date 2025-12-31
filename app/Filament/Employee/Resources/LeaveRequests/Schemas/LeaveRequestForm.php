<?php

namespace App\Filament\Employee\Resources\LeaveRequests\Schemas;

use Carbon\Carbon;
use Filament\Forms\Components\Hidden;
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
                    ->label(__('Name'))
                    ->relationship('user', 'name')
                    ->default(auth()->user()->id)
                    ->disabled()
                    ->dehydrated()
                    ->required(),
                Select::make('leave_type_id')
                    ->label(__('Leave Type'))
                    ->relationship('leaveType', 'name')
                    ->searchable()
                    ->preload()
                    ->required(),
                DatePicker::make('start_date')
                    ->label(__('Start Date'))
                    ->minDate(now()->subDay())
                    ->live()
                    ->required()
                    ->afterStateUpdated(fn($state, Get $get, Set $set) => 
                        self::calculateDays($get, $set)
                    ),
                DatePicker::make('end_date')
                    ->label(__('End Date'))
                    ->minDate(now())
                    ->live()
                    ->required()
                    ->afterStateUpdated(fn($state, Get $get, Set $set) => 
                        self::calculateDays($get, $set)
                    ),
                TextInput::make('days')
                    ->label(__('Days'))
                    ->required()
                    ->disabled()
                    ->dehydrated()
                    ->numeric(),
                Textarea::make('reason')
                    ->label(__('Reason'))
                    ->required()
                    ->columnSpanFull(),
                // Select::make('status')
                //     ->options(['pending' => 'Pending', 'approved' => 'Approved', 'rejected' => 'Rejected'])
                //     ->default('pending')
                //     ->required(),
                Hidden::make('status')
                ->default('pending')
            ]);
    }

    protected static function calculateDays(Get $get, Set $set){
        $start = $get('start_date');
        $end = $get('end_date');

        if($start && $end){
            $startDate = Carbon::parse($start);
            $endDate = Carbon::parse($end);

            $days = $startDate->diffInDays($endDate) + 1;

            $set('days', $days);

        }
    }
}
