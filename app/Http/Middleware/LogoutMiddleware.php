<?php

namespace App\Http\Middleware;

use Closure;

class LogoutMiddleware{
    public function handle($request, Closure $next){
        if(!($request->input('name')=='user' && $request->input('pass')=='123')){
            return response('Unauthorized.', 401);
        }
        return $next($request);
    }
}