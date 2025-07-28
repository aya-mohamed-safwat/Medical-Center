<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use function App\Helpers\json;

class CheckPermission
{
    public function handle(Request $request, Closure $next , String $permission): Response
    {
        $user = auth()->user();

        if($user->hasPermission($permission) || $user->role->name === 'admin'){
            return $next($request);
        }
        return json(__('response.success') , __('response.error.permission'),'',403);
    }
}
