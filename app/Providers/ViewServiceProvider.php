<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\ActivityLog;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        view()->composer("*", function($view) {
            if (auth()->check()) {
                $activity = ActivityLog::where("causer_id", auth()->user()->id)
                    ->orderByDesc("created_at")
                    ->whereDate("created_at", date("Y-m-d"))
                    ->limit(7)
                    ->get();

                $view->with("globals_activity", $activity);
            }
        });
    }
}
