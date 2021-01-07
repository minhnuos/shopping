<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckAdmin
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
        if(Auth::check()) {
            $user = Auth::user();
            if($user->is_admin == 1) {
                return $next($request);
            } else {
                return redirect()->route('admin.login');
            }
        } else {
            return redirect()->route('admin.login');
        }

    }
}
