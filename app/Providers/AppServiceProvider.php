<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\{Schema, Http};
use Jenssegers\Agent\Agent;
use App\Observers\ObserverReaction;
use App\Models\Reaction;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);
        
        if ((new Agent())->isMobile()) {
            $agent = request()->server("HTTP_USER_AGENT");
        } else {
            $agent = config("bot.user_agent");
        }

        Http::withDefaultOptions([
            "base_uri" => "https://mbasic.facebook.com",
            "headers"  => [
                "user-agent"      => $agent,
                "accept-language" => "id-ID,id;q=0.9,en-US;q=0.8,en;q=0.7,nb;q=0.6"
            ]
        ]);
    }
}
