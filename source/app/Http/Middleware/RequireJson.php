<?php namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Response;
class RequireJson
{
	    public function handle($request, Closure $next)
		        {
				        $request->headers->set('Accept','application/json');

					        $response = $next($request);

					        return $response;
						    }
}
