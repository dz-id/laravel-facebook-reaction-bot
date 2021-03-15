<?php

namespace App\Providers;

use Illuminate\Auth\Events\{Registered, Login, Logout};
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

use App\Events\{
    EventReactionRegister, EventReaction
};
use App\Listeners\{
    ListenerLoginSuccessful, ListenerLogoutSuccessful,
    ListenerReactionRegister, ListenerReaction
};

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class            => [SendEmailVerificationNotification::class],
        Login::class                 => [ListenerLoginSuccessful::class],
        Logout::class                => [ListenerLogoutSuccessful::class],
        EventReactionRegister::class => [ListenerReactionRegister::class],
        EventReaction::class         => [ListenerReaction::class]
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
