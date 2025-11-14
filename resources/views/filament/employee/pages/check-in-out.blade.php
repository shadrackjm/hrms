<x-filament-panels::page>
    <x-filament::section>
        <x-slot name="heading">
            {{ now()->format('l, F d, Y') }}
        </x-slot>

        <div class="text-center space-y-6">
            {{-- Live Clock --}}
            <div>
                <p class="text-5xl font-bold" 
                   x-data="{ time: '{{ now()->format('h:i:s A') }}' }" 
                   x-init="setInterval(() => { time = new Date().toLocaleTimeString('en-US') }, 1000)"
                   x-text="time">
                </p>
            </div>

            @if($todayAttendance)
                {{-- Check In/Out Times --}}
                <div class="fi-section-content-ctn">
                    <div class="fi-section-content">
                        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 1rem;">
                            {{-- Check In Card --}}
                            <x-filament::card>
                                <div style="text-align: center; padding: 1rem;">
                                    <x-filament::icon 
                                        icon="heroicon-o-arrow-right-on-rectangle" 
                                        class="w-6 h-6 text-success-500"
                                        style="width: 1.5rem; height: 1.5rem; margin: 0 auto 0.5rem;"
                                    />
                                    <p style="font-size: 0.875rem; font-weight: 500; color: rgb(107 114 128); margin-bottom: 0.5rem;">
                                        Check In Time
                                    </p>
                                    <p style="font-size: 1.5rem; font-weight: 700; color: rgb(34 197 94);">
                                        {{ $todayAttendance->check_in?->format('h:i A') ?? 'Not checked in' }}
                                    </p>
                                </div>
                            </x-filament::card>

                            {{-- Check Out Card --}}
                            <x-filament::card>
                                <div style="text-align: center; padding: 1rem;">
                                    <x-filament::icon 
                                        icon="heroicon-o-arrow-left-on-rectangle" 
                                        class="w-6 h-6 text-danger-500"
                                        style="width: 1.5rem; height: 1.5rem; margin: 0 auto 0.5rem;"
                                    />
                                    <p style="font-size: 0.875rem; font-weight: 500; color: rgb(107 114 128); margin-bottom: 0.5rem;">
                                        Check Out Time
                                    </p>
                                    <p style="font-size: 1.5rem; font-weight: 700; color: rgb(239 68 68);">
                                        {{ $todayAttendance->check_out?->format('h:i A') ?? 'Not checked out' }}
                                    </p>
                                </div>
                            </x-filament::card>
                        </div>
                    </div>
                </div>

                

                {{-- Working Hours Calculation --}}
                @if($todayAttendance->check_in && $todayAttendance->check_out)
                    <x-filament::card>
                        <div style="text-align: center;">
                            <p style="font-size: 0.875rem; font-weight: 500; color: rgb(107 114 128); margin-bottom: 0.5rem;">
                                Total Working Hours
                            </p>
                            <p style="font-size: 1.875rem; font-weight: 700; color: rgb(59 130 246);">
                                {{ $todayAttendance->check_in->diff($todayAttendance->check_out)->format('%H:%I:%S') }}
                            </p>
                        </div>
                    </x-filament::card>
                @endif
            @else
                {{-- No Attendance Today --}}
                <x-filament::card>
                    <div style="text-align: center; padding: 2rem;">
                        <x-filament::icon 
                            icon="heroicon-o-clock" 
                            style="width: 4rem; height: 4rem; margin: 0 auto 1rem; color: rgb(156 163 175);"
                        />
                        <p style="font-size: 1.125rem; font-weight: 500; color: rgb(107 114 128);">
                            You haven't checked in today
                        </p>
                        <p style="font-size: 0.875rem; color: rgb(156 163 175); margin-top: 0.5rem;">
                            Click the "Check In" button above to mark your attendance
                        </p>
                    </div>
                </x-filament::card>
            @endif

            {{-- Attendance Stats --}}
            <x-filament::section>
                <x-slot name="heading">
                    This Month's Summary
                </x-slot>

                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1rem;">
                    <x-filament::card>
                        <div style="text-align: center;">
                            <p style="font-size: 0.875rem; color: rgb(107 114 128);">Present Days</p>
                            <p style="font-size: 1.5rem; font-weight: 700; color: rgb(34 197 94);">
                                {{ \App\Models\Attendance::where('user_id', auth()->id())
                                    ->whereMonth('date', now()->month)
                                    ->where('status', 'present')
                                    ->count() }}
                            </p>
                        </div>
                    </x-filament::card>

                    <x-filament::card>
                        <div style="text-align: center;">
                            <p style="font-size: 0.875rem; color: rgb(107 114 128);">Late Days</p>
                            <p style="font-size: 1.5rem; font-weight: 700; color: rgb(234 179 8);">
                                {{ \App\Models\Attendance::where('user_id', auth()->id())
                                    ->whereMonth('date', now()->month)
                                    ->where('status', 'late')
                                    ->count() }}
                            </p>
                        </div>
                    </x-filament::card>

                    <x-filament::card>
                        <div style="text-align: center;">
                            <p style="font-size: 0.875rem; color: rgb(107 114 128);">Absent Days</p>
                            <p style="font-size: 1.5rem; font-weight: 700; color: rgb(239 68 68);">
                                {{ \App\Models\Attendance::where('user_id', auth()->id())
                                    ->whereMonth('date', now()->month)
                                    ->where('status', 'absent')
                                    ->count() }}
                            </p>
                        </div>
                    </x-filament::card>
                </div>
            </x-filament::section>
        </div>
    </x-filament::section>
</x-filament-panels::page>