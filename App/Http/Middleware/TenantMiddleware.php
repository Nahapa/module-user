<?php

namespace Modules\User\App\Http\Middeware;

use Closure;

class TenantMiddleware
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
        $user = \Auth::user();
        $tenant = $user->userTenant->tenant;
        \Tenant::setTenant($tenant);
        return $next($request);
    }
}
