<?php

namespace App\Http\Middleware;

use Closure;

class CheckPass
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if($request->api_pass !== env('API_PASS','Ul9ryyZGlkisHd'))
        {
            return response()->json(['message'=>'Unauthenticated']);
        }
        return $next($request);
    }
}
