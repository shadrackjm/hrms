<?php

namespace App\Filament\Hr\Resources\Payrolls\Schemas;

use App\Models\User;
use Filament\Schemas\Schema;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;

class PayrollForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('user_id')
                    ->relationship('user', 'name')
                    ->searchable()
                    ->preload()
                    ->live()
                    ->required()
                    ->afterStateUpdated(function($state,Set $set){
                        $user = User::find($state);
                        if($user){
                            $set('basic_salary', $user->salary);
                        }
                    }),
                Select::make('month')
                    ->options([
                        'January' => 'January',
                        'February' => 'February',
                        'March' => 'March',
                        'April' => 'April',
                        'May' => 'May',
                        'June' => 'June',
                        'July' => 'July',
                        'August' => 'August',
                        'September' => 'September',
                        'October' => 'October',
                        'November' => 'November',
                        'December' => 'December',
                    ])
                    ->required(),
                TextInput::make('year')
                    ->required()
                    ->numeric()
                    ->default(date('Y')),
                TextInput::make('basic_salary')
                    ->required()
                    ->numeric()
                    ->prefix('$')
                    ->live()
                    ->afterStateUpdated(fn($state, Set $set, Get $get) => 
                        self::calculateNetSalary($set,$get)
                ),
                TextInput::make('allowances')
                    ->required()
                    ->numeric()
                    ->default(0.0)
                    ->prefix('$')
                    ->live(onBlur: true)
                    ->afterStateUpdated(fn($state, Set $set, Get $get) => 
                        self::calculateNetSalary($set,$get)
                ),
                TextInput::make('deductions')
                    ->required()
                    ->numeric()
                    ->default(0.0)
                    ->prefix('$')
                    ->live(onBlur: true)
                    ->afterStateUpdated(fn($state, Set $set, Get $get) => 
                        self::calculateNetSalary($set,$get)
                ),
                TextInput::make('bonus')
                    ->required()
                    ->numeric()
                    ->default(0.0)
                    ->prefix('$')
                    ->live(onBlur: true)
                    ->afterStateUpdated(fn($state, Set $set, Get $get) => 
                        self::calculateNetSalary($set,$get)
                ),
                TextInput::make('net_salary')
                    ->required()
                    ->disabled()
                    ->prefix('$')
                    ->dehydrated()
                    ->numeric(),
                Select::make('status')
                    ->options(['draft' => 'Draft', 'processed' => 'Processed', 'paid' => 'Paid'])
                    ->default('draft')
                    ->required(),
                DatePicker::make('paid_at'),
            ]);
    }

    protected static function calculateNetSalary(Set $set, Get $get){
        $basic = (float) ($get('basic_salary') ?? 0);
        $allowances = (float) ($get('allowances') ??0);
        $deductions = (float) ($get('deductions') ??0);
        $bonus = (float) ($get('bonus') ??0);

        // net salary
        $netSalary = $basic + $allowances + $bonus - $deductions;

        $set('net_salary', $netSalary);
    }
}
