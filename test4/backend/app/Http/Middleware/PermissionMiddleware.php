<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class PermissionMiddleware
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

        // dd(getRouteMid());
        // dd(explode(".",$request->route()->getName()));
        // hasAnyPermission
        // dd(\Auth::check());
        if($request->route()->getName()){
            if(\Auth::check() && ($request->route()->getName() != 'logout')){
                if(\Auth::check()){
                    $res = explode(".",$request->route()->getName());
                    if($res[0] == 'option'){
                        return $next($request);
                    }else{
                        if(!auth()->user()->hasAnyPermission([getRouteMid()])){
                            // dd(getRouteMid());
                            // if(\Auth::check()){
                            //     redirect('sandar');
                            // }else{
                                abort(404);
                            // }
                        }
                    }
                }
            }
        }
        
       
        return $next($request);
    }
}
