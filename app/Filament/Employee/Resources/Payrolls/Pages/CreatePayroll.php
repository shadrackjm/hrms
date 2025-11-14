<?php

namespace App\Filament\Employee\Resources\Payrolls\Pages;

use App\Filament\Employee\Resources\Payrolls\PayrollResource;
use Filament\Resources\Pages\CreateRecord;

class CreatePayroll extends CreateRecord
{
    protected static string $resource = PayrollResource::class;
}
