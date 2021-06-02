<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Category;

class verifyCategorisCount
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
        if(Category::all()->count() == 0){
            //redirect to the route you came from: 
            return redirect(route('categories.create'))->with('error', "You must create a category first!");
        }
        
        //next means proceeds, to the routes you asking for
        return $next($request);
    }
}
