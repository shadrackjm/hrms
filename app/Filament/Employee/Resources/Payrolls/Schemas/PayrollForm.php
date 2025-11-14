<?php

namespace App\Filament\Employee\Resources\Payrolls\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class PayrollForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('user_id')
                    ->relationship('user', 'name')
                    ->required(),
                TextInput::make('month')
                    ->required(),
                TextInput::make('year')
                    ->required()
                    ->numeric(),
                TextInput::make('basic_salary')
                    ->required()
                    ->numeric(),
                TextInput::make('allowances')
                    ->required()
                    ->numeric()
                    ->default(0.0),
                TextInput::make('deductions')
                    ->required()
                    ->numeric()
                    ->default(0.0),
                TextInput::make('bonus')
                    ->required()
                    ->numeric()
                    ->default(0.0),
                TextInput::make('net_salary')
                    ->required()
                    ->numeric(),
                Select::make('status')
                    ->options(['draft' => 'Draft', 'processed' => 'Processed', 'paid' => 'Paid'])
                    ->default('draft')
                    ->required(),
                DatePicker::make('paid_at'),
            ]);
    }
}
