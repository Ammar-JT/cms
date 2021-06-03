<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\User;

class verifyIsAdmin
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
        if(!auth()->user()->isAdmin()){
            return redirect(route('home'))->with('error', 'YOU ARE NOT AUTHERIZED to enter this page');
        }
        return $next($request);
    }
}
