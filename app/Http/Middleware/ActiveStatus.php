<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class ActiveStatus
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->user() && !$request->user()->isActive()) {
            Auth::logout();
            //Destruir la sesión
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            // Redireccionar o enviar un mensaje de error
            return redirect()->route('login')->with('error', 'Tu cuenta no se encuentra activa.');
        }
        return $next($request);
    }
}
