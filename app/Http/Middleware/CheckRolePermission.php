<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use DB;

// use App\Http\Controllers\UserController;

class CheckRolePermission
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

        if (Auth::check()) {

            $has_access =    has_access();
            $user = Auth::User();

            if (!$has_access) {
                if($user->u_type =='CEO' || $user->u_type =='A'){
                    return redirect('home')->withErrors(['message'   =>  'Your don\'t have permission to access this page']);
                }else{
                    return redirect('qualitycheck')->withErrors(['message'   =>  'Your don\'t have permission to access this page']);
                }

            }
        }
        return $next($request);
    }
}
