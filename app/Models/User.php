<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\Contracts\Activity;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasRoles, LogsActivity;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name', 'email', 'password', 'department_id', 'position_id', 
        'employee_id', 'phone', 'date_of_birth', 'hire_date', 
        'employment_type', 'status', 'salary', 'address', 
        'emergency_contact_name', 'emergency_contact_phone'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'salary' => 'decimal:2'
        ];
    }
    public function department(): BelongsTo
{
    return $this->belongsTo(Department::class);
}

public function position(): BelongsTo
{
    return $this->belongsTo(Position::class);
}

public function attendances(): HasMany
{
    return $this->hasMany(Attendance::class);
}

public function leaveRequests(): HasMany
{
    return $this->hasMany(LeaveRequest::class);
}

public function payrolls(): HasMany
{
    return $this->hasMany(Payroll::class);
}

public function performanceReviews(): HasMany
{
    return $this->hasMany(PerformanceReview::class);
}

    protected static function boot()
    {
        parent::boot();
        //EMP-0001

        static::creating(function ($employee) {
            if (empty($employee->employee_id)) {
                $lastEmployee = static::orderBy('id','desc')->first(); 

                $nextNumber = 1;

                if ($lastEmployee && $lastEmployee->employee_id) {
                    if (preg_match('/^EMP-(\d+)$/', $lastEmployee->employee_id,$matches)) {
                        $nextNumber = ((int) $matches[1]) + 1;
                    }
                }

                $employee->employee_id = 'EMP-' . str_pad($nextNumber, 6,'0', STR_PAD_LEFT);
            }
        });
    }
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logAll()
            ->logOnlyDirty()
            ->dontLogIfAttributesChangedOnly(['password', 'remember_token']);
    }

    public function tapActivity(Activity $activity, string $eventName)
    {
        $activity->properties = $activity->properties->put('ip', request()->ip());
        $activity->properties = $activity->properties->put('user_agent', request()->userAgent());
    }
}
