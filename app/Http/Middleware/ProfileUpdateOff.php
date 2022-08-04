<?php

namespace App\Http\Middleware;

use App\UserProfileUpdatePlan;
use Closure;

class ProfileUpdateOff
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
        $user = auth()->user();
        if (!is_null($user))
            if ($user->update_record == "N") {
                return redirect()->route('home');
            } else {
                $plan = UserProfileUpdatePlan::whereUserId($user->id)->whereStatus('A')->first();
                $current_route = \Route::currentRouteName();
                if (!is_null($plan))
                    if ($current_route != $plan->route && !in_array($current_route, $plan->exception_routes)) {
                        return redirect()->route($plan->route);
                    }

            }
        return $next($request);
    }
}
