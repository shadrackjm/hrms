<?php

namespace App\Filament\Widgets;

use App\Models\User;
use App\Models\Attendance;
use App\Models\Department;
use App\Models\LeaveRequest;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends StatsOverviewWidget
{
    protected ?string $pollingInterval = '60s';
    protected function getStats(): array
    {
        return [
            Stat::make(__('Total Employees'), User::count())
            ->description(__('Active employees in system'))
            ->descriptionIcon('heroicon-o-users')
            ->color('success'),
            Stat::make(__('Departments'), Department::count())
                ->description(__('Total departments'))
                ->descriptionIcon('heroicon-o-building-office')
                ->color('info'),
                    Stat::make(__('Pending Leave Requests'), LeaveRequest::where('status', 'pending')->count())
                    ->description(__('Awaiting approval'))
                    ->descriptionIcon('heroicon-o-calendar-days')
                    ->color('warning'),
            
            Stat::make(__('Today\'s Attendance'), Attendance::whereDate('date', today())->count())
                ->description(__('Checked in today'))
                ->descriptionIcon('heroicon-o-clock')
                ->color('primary'),
        ];
    }
}
