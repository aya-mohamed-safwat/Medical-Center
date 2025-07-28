<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use function App\Helpers\json;

class IsActive
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        {
            $currentUser=Auth::user();
            $active=$currentUser->active;
            if($active== false)
            {
                return json('failed','Your account is not active.','', 403);
            }
            return $next($request);
        }
    }
}
