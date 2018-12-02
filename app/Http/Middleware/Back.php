<?php

    namespace App\Http\Middleware;

    use Closure;

    class Back
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
            if(auth()->check() && auth()->user()->is_admin == 1)
                return $next($request);
            else
                abort(401);
        }
    }
