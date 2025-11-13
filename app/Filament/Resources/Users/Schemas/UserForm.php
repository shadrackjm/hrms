<?php

namespace App\Filament\Resources\Users\Schemas;

use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Hash;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\ToggleButtons;
use Filament\Schemas\Components\Utilities\Get;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make("Personal Informations")
                ->columns(2)
                ->schema([
                    TextInput::make('name')
                    ->required(),
                    TextInput::make('email')
                    ->label('Email address')
                    ->email()
                    ->required(),
                    TextInput::make('password')
                    ->password()
                    ->revealable()
                    ->dehydrateStateUsing(fn($state) => Hash::make($state))
                    ->dehydrated(fn($state) => filled($state))
                    ->required(fn(string $context): bool => $context === 'create'),
                    TextInput::make('phone')
                    ->tel()
                    ->default(null),
                    DatePicker::make('date_of_birth'),
                    Textarea::make('address')
                    ->default(null)
                    ->columnSpanFull(),
                    Select::make('roles')
                    ->relationship('roles', 'name')
                    ->multiple()
                    ->preload()
                    ->searchable(),

                ]),

                Section::make('Employment Details')
                ->columns(2)
                ->schema([
                    TextInput::make('employee_id')
                    ->label('Employee Code')
                    ->readOnly()
                    ->unique(ignoreRecord: true)
                    ->hiddenOn('create'),

                    Select::make('department_id')
                    ->relationship('department', 'name')
                    ->required()
                    ->searchable()
                    ->preload()
                    ->live(),

                    Select::make('position_id')
                    ->relationship('position', 'title', fn($query, Get $get)=> 
                        $query->where('department_id', $get('department_id')))
                    ->required()
                    ->searchable()
                    ->preload(),

                    DatePicker::make('hire_date')
                    ->required(),
                    ToggleButtons::make('employment_type')
                    ->options([
                        'full-time' => 'Full time',
                        'part-time' => 'Part time',
                        'contract' => 'Contract',
                        'intern' => 'Intern',
                    ])
                    ->colors([
                        'full-time'=> 'success',
                        'part-time'=> 'warning',
                        'contract'=> 'danger',
                        'intern'=> 'info',
                    ])
                    ->grouped()
                    ->default('full-time')
                    ->columnSpanFull()
                    ->required(),

                    Select::make('status')
                    ->options([
                        'active' => 'Active',
                        'inactive' => 'Inactive',
                        'on-leave' => 'On leave',
                        'terminated' => 'Terminated',
                    ])
                    ->default('active')
                    ->required(),
                    TextInput::make('salary')
                    ->numeric()
                    ->default(null),
                ]),
               
                Section::make('Emergency Contact')
                ->schema([
                    TextInput::make('emergency_contact_name')
                    ->default(null),
                    TextInput::make('emergency_contact_phone')
                    ->tel()
                    ->default(null),
                ])
                
            ]);
    }
}
