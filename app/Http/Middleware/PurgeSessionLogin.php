<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Auth;

class PurgeSessionLogin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();

        if (! empty($user->purge_session_login)) {
            $user->purge_session_login = false;

            Auth::guard()->logout();

            session()->regenerate(true);

            return redirect()->route("home");
        }

        return $next($request);
    }
}
