<?php

namespace App\Http\Middleware;

use App\UserProfileUpdatePlan;
use Closure;

class ProfileUpdateChecker
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (auth()->user()->update_record == "Y") {
            $plan = UserProfileUpdatePlan::whereUserId(auth()->id())->whereStatus('A')->first(['route']);
            if (!is_null($plan))
                return redirect()->route($plan->route);
        }
        return $next($request);
    }
}
