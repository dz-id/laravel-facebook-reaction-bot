<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Login;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class ListenerLoginSuccessful
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  IlluminateAuthEventsLigin  $event
     * @return void
     */
    public function handle(Login $event)
    {
        activity("auth")
            ->causedBy($event->user)
            ->withProperties(["name" => "logged-in"])
            ->log("Telah Login ke Akun");
        
        session()->flash("alert_success", "Selamat datang " . $event->user->fb_name);
    }
}
