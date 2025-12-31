<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Activitylog\Contracts\Activity;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class PerformanceReview extends Model
{
    use HasFactory, LogsActivity;

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->logAll()->logOnlyDirty();
    }

    public function tapActivity(Activity $activity, string $eventName)
    {
        $activity->properties = $activity->properties->put('ip', request()->ip());
        $activity->properties = $activity->properties->put('user_agent', request()->userAgent());
    }

    protected $fillable = [
        'user_id', 'reviewer_id', 'review_period', 'quality_of_work', 
        'productivity', 'communication', 'teamwork', 'leadership', 
        'overall_rating', 'strengths', 'areas_for_improvement', 'goals', 'comments'
    ];

    protected $casts = [
        'overall_rating' => 'decimal:2',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function reviewer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'reviewer_id');
    }
}
