<?php

namespace App\Http\Middleware;
use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Support\Facades\Auth;
use Closure;
use Illuminate\Support\Facades\Lang;

class Authenticate extends Middleware
{
    public function handle($request, Closure $next, $guard = null)
    {
        if(Auth::guard($guard)->guest()){
            return response()->json([
                'result' => '-1',
                'error_code' => '401',
                'error_message' => 'Unauthorized',
            ], 401);
        }
        return $next($request);
    }
}
