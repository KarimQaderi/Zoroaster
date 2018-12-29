<?php

    namespace KarimQaderi\Zoroaster\Http\Middleware;

    use Closure;
    use Illuminate\Support\Facades\Auth;

    class CheckLogin
    {
        public function handle($request , Closure $next)
        {

            if(Auth::Guest())
                return redirect( route('Zoroaster.login'));

            return $next($request);


        }
    }
