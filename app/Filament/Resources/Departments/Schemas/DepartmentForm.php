<?php

namespace App\Filament\Resources\Departments\Schemas;

use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class DepartmentForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make("Department Informations")
                ->columns(2)
                ->columnSpanFull()
                ->schema([
                    TextInput::make('name')
                        ->required(),
                    Select::make('manager_id')
                        ->relationship('manager', 'name')
                        ->default(null),
                    ColorPicker::make('color')
                    ->label('Color'),
                    Textarea::make('description')
                        ->default(null)
                        ->columnSpanFull(),
                    
                ])
                
            ]);
    }
}
