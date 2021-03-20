<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IsUser
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
        if(Auth::user()->user_type == 'user') {
            return $next($request);
        } else {
            if(Auth::user()->user_type == 'admin' || Auth::user()->user_type == 'staff') {
                return redirect()->route('orders');
            } else {
                return redirect()->route('home');
            }
        }
    }
}
