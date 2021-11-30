<?php

namespace App\Http\Middleware;

use Closure;

class AccessRights
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $access_rights)
    {
        $allowed_access_rights = explode(':', $access_rights);
     
        if (in_array(\Auth::user()->access_rights, $allowed_access_rights)) {
            return $next($request);
        }
        return redirect('/shop');
    }
}
