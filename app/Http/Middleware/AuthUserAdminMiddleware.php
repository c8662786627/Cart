<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AuthUserAdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $is_allow_access = false;
        $user = Auth::guard('api')->user();
        
        if(!is_null($user)){
            if ($user->level=='A') {
                # code...
                $is_allow_access = true;
            }
        }else{
            return response('請確實登入',401);
        }
        if (!$is_allow_access) {
            return response('沒有權限',401);
        }
        return $next($request);
        
    }
}
