<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class EnsurePhoneIsVerified
{
    public function handle($request, Closure $next)
    {
        // تخطى الشرط إذا المستخدم غير مسجل دخول
        if (!Auth::check()) {
            return $next($request);
        }

        if (!Auth::user()->hasVerifiedPhone()) {
            return redirect()->route('phone.verify');
        }

        return $next($request);
    }
}
