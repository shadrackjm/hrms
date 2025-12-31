<?php

namespace App\Filament\Pages\Auth;

use Filament\Auth\Pages\Login as BaseLogin;
use Illuminate\Contracts\Support\Htmlable;

class Login extends BaseLogin
{
    protected string $view = 'filament.pages.auth.login';

    public function getHeading(): string | Htmlable
    {
        return match (filament()->getCurrentPanel()->getId()) {
            'admin' => 'Admin Portal',
            'hr' => 'HR Management',
            'employee' => 'Employee Self Service',
            default => parent::getHeading(),
        };
    }

    public function getSubheading(): string | Htmlable | null
    {
        return match (filament()->getCurrentPanel()->getId()) {
            'admin' => __('Access the administrative control center.'),
            'hr' => __('Manage employee data and company operations.'),
            'employee' => __('Access your personal work profile and attendance.'),
            default => parent::getSubheading(),
        };
    }

    public function getImage(): string
    {
        return asset('images/' . filament()->getCurrentPanel()->getId() . '-login.png');
    }
}
