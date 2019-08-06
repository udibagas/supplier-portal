<?php

namespace App\Http\Middleware;

use Closure;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $role)
    {
        if ($request->auth()->role !== $role) {
            return response(['message' => 'You are not allowed to access this service,'], 403);
        }

        return $next($request);
    }
}
