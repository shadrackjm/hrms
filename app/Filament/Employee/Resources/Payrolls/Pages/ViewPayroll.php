<?php

namespace App\Filament\Employee\Resources\Payrolls\Pages;

use App\Filament\Employee\Resources\Payrolls\PayrollResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewPayroll extends ViewRecord
{
    protected static string $resource = PayrollResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
