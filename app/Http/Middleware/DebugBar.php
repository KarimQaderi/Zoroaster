<?php namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Cookie;

class DebugBar
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */


    public function handle($request , Closure $next)
    {



//        Config::set('app.debug' , false);
//
//        if($request->has('debug'))
//            Cookie::queue('debug' , $request->debug , 60 * 24 * 30);
//
//        if((auth()->check() && Auth()->id() == 0 || Auth()->id() == 1))
//
//            if(Cookie::has('debug') == "true" && Cookie::get('debug') == "true")
//                Config::set('app.debug' , true);

//        if((strpos(Request::root() , '127.0.0.1') != false || strpos(Request::root() , 'localhost') != false) && Cookie::has('debug')==true)
//            Config::set('app.debug' , true);

        return $next($request);
    }
}