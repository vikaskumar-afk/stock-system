<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $role): Response
    {
        if (!$request->user() || $request->user()->role != $role) {
            $target = $request->user() && $request->user()->role == 0 ? '/admin' : '/customer';

            // If already on the target, just abort to prevent redirect loops, 
            // but under normal circumstances, we redirect to the correct home.
            if ($request->is(ltrim($target, '/') . '*')) {
                return $next($request);
            }

            // return redirect($target)->with('error', 'You do not have permission to access this page.');
            return redirect($target);
        }

        return $next($request);
    }
}
