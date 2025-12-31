<?php

namespace App\Filament\Employee\Pages;

use Filament\Actions\Action;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use App\Models\Attendance;
use BezhanSalleh\FilamentShield\Traits\HasPageShield;
use UnitEnum;
use BackedEnum;

class CheckInOut extends Page
{
    use HasPageShield;
    protected string $view = 'filament.employee.pages.check-in-out';
    protected static string | BackedEnum | null $navigationIcon = 'heroicon-o-clock';
    protected static ?string $navigationLabel = 'Check In/Out';
    protected static string | UnitEnum | null $navigationGroup = 'Attendance';
    protected static ?int $navigationSort = 1;

    public $todayAttendance;
    public $canCheckIn = false;
    public $canCheckOut = false;
    public $currentTime;

    public function mount()
    {
        $this->loadAttendance();
        $this->currentTime = now()->format('H:i:s A');
    }

    public function loadAttendance()
    {
        $this->todayAttendance = Attendance::where('user_id', auth()->user()->id)
            ->where('date', today())
            ->first();

            $this->canCheckIn = !$this->todayAttendance || $this->todayAttendance->check_in === null;
            $this->canCheckOut = $this->todayAttendance && $this->todayAttendance->check_in !== null && $this->todayAttendance->check_out === null;
    }

    public function CheckIn(){
        try {
            if(!$this->canCheckIn){
                return;
            }
    
            $this->todayAttendance = Attendance::create([
                'user_id' => auth()->user()->id,
                'date' => today(),
                'check_in' => now(),
                'status' => now()->format('H:i') > '09:00' ? 'late' : 'present',
            ]);
    
            Notification::make()
            ->success()
            ->title(__('Checked In Successfully'))
            ->body(__('Your check-in time: '). now()->format('h:i A'))
            ->send();
    
            $this->loadAttendance();
        } catch (\Exception $e) {
            Notification::make()
            ->danger()
            ->title(__('Check-in Failed'))
            ->body(__('You have already checked in today'))
            ->send();
        }
    }

    public function checkOut(){
        if($this->todayAttendance){
            $this->todayAttendance->update([
                'check_out' => now()
            ]);

            Notification::make()
            ->success()
            ->title(__('Checked Out successfully'))
            ->body(__('your check-out time: '). now()->format('h:i A'))
            ->send();

            $this->loadAttendance();
        }
    }

    protected function getHeaderActions(): array {
        return [
            Action::make('checkIn')
            ->label(__('Check In'))
            ->icon('heroicon-o-arrow-right-on-rectangle')
            ->color('success')
            ->visible(fn() => $this->canCheckIn)
            ->requiresConfirmation()
            ->modalHeading(__('check in'))
            ->modalDescription(__('Are you sure you want to check in now?'))
            ->modalSubmitActionLabel(__('Yes, Check In'))
            ->action(fn() => $this->CheckIn()),

            Action::make('checkOut')
            ->label(__('Check Out'))
            ->icon('heroicon-o-arrow-left-on-rectangle')
            ->color('danger')
            ->visible(fn() => $this->canCheckOut)
            ->requiresConfirmation()
            ->modalHeading(__('check out'))
            ->modalDescription(__('Are you sure you want to check out now?'))
            ->modalSubmitActionLabel(__('Yes, Check Out'))
            ->action(fn() => $this->checkOut())
        ];
    }

}
