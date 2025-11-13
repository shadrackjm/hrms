<?php

namespace App\Filament\Resources\LeaveTypes\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class LeaveTypeForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make("Leave Details")
                ->columnSpanFull()
                ->columns(2)
                ->schema([
                    TextInput::make('name')
                    ->required(),
                    TextInput::make('days_per_year')
                        ->required()
                        ->numeric(),
                    Toggle::make('is_paid')
                        ->required(),
                ])
                
            ]);
    }
}
