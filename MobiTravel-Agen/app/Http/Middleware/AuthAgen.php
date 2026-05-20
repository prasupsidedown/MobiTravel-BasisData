<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AuthAgen
{
    public function handle(Request $request, Closure $next)
    {
        if (!$request->session()->has('agen_token')) {
            return redirect('/login')->with('error', 'Silakan login sebagai agen terlebih dahulu');
        }
        
        return $next($request);
    }
}