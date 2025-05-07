<?php

namespace App\Http\Middleware;
use Illuminate\Support\Facades\Auth;
use Closure;
use Illuminate\Http\Request;

class CheckOtp
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
        $user = Auth::user();   
        
        if(($user->u_type == 'M' || $user->u_type == 'QA' || $user->u_type == 'A') && $user->otp_status==1) {
            return $next($request);
        }
        if($user->u_type == 'CEO' ) {
            return $next($request);
        }
        else{
            Auth::logout();
            return redirect('/login');
        }
        
        
    }
}
