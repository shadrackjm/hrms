<?php

namespace App\Filament\Hr\Widgets;

use App\Models\User;
use App\Models\Payroll;
use App\Models\Attendance;
use App\Models\LeaveRequest;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make(__('Active Employees'), User::where('status', 'active')->count())
            ->description(__('Currently active'))
            ->descriptionIcon('heroicon-o-users')
            ->color('success'),
            Stat::make(__('Pending Leaves'), LeaveRequest::where('status', 'pending')->count())
                ->description(__('Requires action'))
                ->descriptionIcon('heroicon-o-calendar-days')
                ->color('warning'),
            Stat::make(__('Today\'s Attendance'), 
                Attendance::whereDate('date', today())->where('status', 'present')->count())
                ->description(__('Present today'))
                ->descriptionIcon('heroicon-o-clock')
                ->color('primary'),
                Stat::make(__('This Month Payroll'), 
                Payroll::where('month', date('F'))
                    ->where('year', date('Y'))
                    ->where('status', 'paid')
                    ->count()
            )
            ->description(__('Processed this month'))
            ->descriptionIcon('heroicon-o-banknotes')
            ->color('info'),
        ];
    }
}
