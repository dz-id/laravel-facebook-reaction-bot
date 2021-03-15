<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Auth\Events\Logout;

class ListenerLogoutSuccessful
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
     * @param  object  $event
     * @return void
     */
    public function handle(Logout $event)
    {
        activity("Auth")
            ->causedBy($event->user)
            ->withProperties(["name" => "logged-out"])
            ->log("Telah Keluar dari Akun");

        session()->flash("alert_warning", "Anda telah keluar !");
    }
}
