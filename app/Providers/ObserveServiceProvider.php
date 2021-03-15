<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\{User, Reaction};
use App\Observers\{ObserverUser, ObserverReaction};

class ObserveServiceProvider extends ServiceProvider
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
        User::observe(ObserverUser::class);
        Reaction::observe(ObserverReaction::class);
    }
}
