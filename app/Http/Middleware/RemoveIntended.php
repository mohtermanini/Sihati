<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RemoveIntended
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
        if (
            session()->has("url.intended")
            &&  (
                $request->url() != route('login') && $request->url() != route('users.create')
            )
        ) {
            session()->remove("url.intended");
        }
        return $next($request);
    }
}
