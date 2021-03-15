<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\Models\Activity;
use App\Models\User;

class ActivityLog extends Activity
{
    use HasFactory, LogsActivity;
    
    protected $table = "activity_log";
    
    public function user()
    {
        return $this->belongsTo(User::class, "causer_id");
    }
}
