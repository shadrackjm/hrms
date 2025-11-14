<?php

namespace App\Filament\Employee\Resources\LeaveRequests\Pages;

use App\Filament\Employee\Resources\LeaveRequests\LeaveRequestResource;
use Filament\Resources\Pages\CreateRecord;

class CreateLeaveRequest extends CreateRecord
{
    protected static string $resource = LeaveRequestResource::class;
}
