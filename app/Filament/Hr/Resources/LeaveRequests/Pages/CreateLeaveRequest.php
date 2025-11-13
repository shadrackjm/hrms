<?php

namespace App\Filament\Hr\Resources\LeaveRequests\Pages;

use App\Filament\Hr\Resources\LeaveRequests\LeaveRequestResource;
use Filament\Resources\Pages\CreateRecord;

class CreateLeaveRequest extends CreateRecord
{
    protected static string $resource = LeaveRequestResource::class;
}
