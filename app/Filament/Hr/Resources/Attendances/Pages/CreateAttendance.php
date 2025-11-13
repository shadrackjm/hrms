<?php

namespace App\Filament\Hr\Resources\Attendances\Pages;

use App\Filament\Hr\Resources\Attendances\AttendanceResource;
use Filament\Resources\Pages\CreateRecord;

class CreateAttendance extends CreateRecord
{
    protected static string $resource = AttendanceResource::class;
}
