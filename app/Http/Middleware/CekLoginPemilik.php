<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CekLoginPemilik
{
    public function handle(Request $request, Closure $next)
    {
        if (!$request->session()->has('is_login')) {
            return redirect('/login');
        }
        return $next($request);
    }
}
