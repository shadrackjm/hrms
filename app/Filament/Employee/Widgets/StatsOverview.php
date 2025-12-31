<?php

namespace App\Filament\Employee\Widgets;

use App\Models\Payroll;
use App\Models\Attendance;
use App\Models\LeaveRequest;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        $userId = auth()->user()->id;
        return [
            Stat::make(__('My Leave Requests'), 
            LeaveRequest::where('user_id', $userId)->count()
        )
            ->description(__('Total leave requests'))
            ->descriptionIcon('heroicon-o-calendar-days')
            ->color('info'),

            Stat::make(__('Pending Leaves'), 
            LeaveRequest::where('user_id', $userId)->where('status', 'pending')->count()
        )
            ->description(__('Awaiting approval'))
            ->descriptionIcon('heroicon-o-clock')
            ->color('warning'),

            Stat::make(__('This Month Attendance'), 
                Attendance::where('user_id', $userId)
                    ->whereMonth('date', date('m'))
                    ->whereYear('date', date('Y'))
                    ->count()
            )
                ->description(__('Days recorded'))
                ->descriptionIcon('heroicon-o-calendar')
                ->color('primary'),

                Stat::make(__('Last Payroll'), 
                Payroll::where('user_id', $userId)
                    ->where('status', 'paid')
                    ->latest()
                    ->first()
                    ?->net_salary ?? 0
            )
                ->description(__('Last payment'))
                ->descriptionIcon('heroicon-o-banknotes')
                ->color('success'),
        ];
    }
}
