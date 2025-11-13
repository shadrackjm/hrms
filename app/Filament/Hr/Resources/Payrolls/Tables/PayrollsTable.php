<?php

namespace App\Filament\Hr\Resources\Payrolls\Tables;

use Filament\Tables\Table;
use Filament\Actions\Action;
use App\Jobs\GeneratePayrollJob;
use Filament\Actions\EditAction;
use Filament\Actions\BulkActionGroup;
use Filament\Forms\Components\Select;
use Filament\Actions\DeleteBulkAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;

class PayrollsTable
{
    public static function configure(Table $table): Table
    {
        return $table
        ->headerActions([
            Action::make("generate_payroll")
            ->label("Generate Payroll")
            ->icon("heroicon-o-cog")
            ->color("success")
            ->schema([
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
                    ->default(now()->format('F'))
                    ->required(),
                TextInput::make('year')
                        ->required()
                        ->numeric()
                        ->default(now()->year)
                        ->minValue(2020)
                        ->maxValue(now()->year + 1),
                Select::make('user_id')
                        ->label('Employee (Optional)')
                        ->placeholder('Generate for all employees')
                        ->relationship('user', 'name')
                        ->searchable()
                        ->preload(),
            ])
            ->action(function(array $data){
                GeneratePayrollJob::dispatch($data['month'], $data['year'], $data['user_id'] ?? null);

                Notification::make()
                ->success()
                ->title('Payroll Gneration started')
                ->body('Payroll is being generated in the background. You will receive will be notified once completed.')
                ->send();
                        })
        ])
            ->columns([
                TextColumn::make('user.name')
                    ->searchable(),
                    TextColumn::make('user.employee_id')
                    ->label('Employee Code')
                    ->searchable(),
                TextColumn::make('month')
                    ->searchable(),
                TextColumn::make('year')
                    ->sortable(),
                TextColumn::make('basic_salary')
                    ->money('USD')
                    ->sortable(),
                
                TextColumn::make('net_salary')
                ->money('USD')
                    ->sortable(),
                TextColumn::make('status')
                    ->badge(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
