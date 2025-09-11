<?php

namespace App\Models\Traits;

use App\Models\ActivityLog;
use Illuminate\Database\Eloquent\Model;

/**
 * Trait for models that should log their activities.
 */
trait LogsActivity
{
    /**
     * Boot the trait.
     */
    protected static function bootLogsActivity()
    {
        static::created(function (Model $model) {
            $model->logActivity('created');
        });

        static::updated(function (Model $model) {
            $model->logActivity('updated');
        });

        static::deleted(function (Model $model) {
            $model->logActivity('deleted');
        });
    }

    /**
     * Log an activity.
     *
     * @param string $description
     * @param string $logName
     * @param array $properties
     * @return \App\Models\ActivityLog
     */
    public function logActivity(string $description, string $logName = 'default', array $properties = [])
    {
        return ActivityLog::create([
            'log_name' => $logName,
            'description' => $description,
            'subject_id' => $this->getKey(),
            'subject_type' => get_class($this),
            'causer_id' => auth()->id(),
            'causer_type' => auth()->user() ? get_class(auth()->user()) : null,
            'properties' => $properties,
        ]);
    }

    /**
     * Get all of the model's activity logs.
     */
    public function activityLogs()
    {
        return $this->morphMany(ActivityLog::class, 'subject');
    }
}
