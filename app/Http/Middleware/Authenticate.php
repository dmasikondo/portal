<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{

    protected $guard = null;

    public function handle($request, Closure $next, ...$guards)
    {
        $this->guard = $guards;
        $this->authenticate($request, $guards);

        return $next($request);
    }

    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request $request
     * @return string
     */
    protected function redirectTo($request)
    {
        return route(((in_array("staff_user", $this->guard)) ? 'staff.login' : 'login'));
    }
}
