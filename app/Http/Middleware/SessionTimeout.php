<?php

// app/Http/Middleware/SessionTimeout.php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class SessionTimeout
{
    protected $timeout = 10; // Set the timeout in minutes

    public function handle($request, Closure $next)
    {
        if (!Auth::check()) {
            return $next($request);
        }

        $lastActivity = session('last_activity_time');
        $currentTime = now()->timestamp;

        if ($lastActivity && ($currentTime - $lastActivity > $this->timeout * 60)) {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect('/login')->with('message', 'You have been logged out due to inactivity.');
        }

        session(['last_activity_time' => $currentTime]);

        return $next($request);
    }
}
