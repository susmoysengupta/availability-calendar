<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class IsPasswordSetMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if (auth()->check() && auth()->user()->password == 'secret' && !$request->password && !$request->is('set_password')) {
            return redirect()->route('set_password');
        }

        if (auth()->check() && auth()->user()->password != 'secret' && $request->is('set_password')) {
            return redirect()->route('calendars.index')->with('info', __('You have already set your password.'));
        }

        return $next($request);
    }
}
