<?php

namespace App\Filament\Employee\Resources\Payrolls\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class PayrollInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('user.name')
                    ->label('User'),
                TextEntry::make('month'),
                TextEntry::make('year')
                    ->numeric(),
                TextEntry::make('basic_salary')
                    ->numeric(),
                TextEntry::make('allowances')
                    ->numeric(),
                TextEntry::make('deductions')
                    ->numeric(),
                TextEntry::make('bonus')
                    ->numeric(),
                TextEntry::make('net_salary')
                    ->numeric(),
                TextEntry::make('status')
                    ->badge(),
                TextEntry::make('paid_at')
                    ->date()
                    ->placeholder('-'),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),
            ]);
    }
}
