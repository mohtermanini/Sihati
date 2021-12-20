<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class FlashPreviousURL
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
        if(!session()->has('previous_entry_url')){
            session()->flash('previous_entry_url', url()->previous(route('index')));
        }else{
            session()->keep(['previous_entry_url']);
        }
        return $next($request);
    }
}
