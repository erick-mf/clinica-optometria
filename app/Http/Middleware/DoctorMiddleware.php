<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class DoctorMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Verifica si el usuario está autenticado y es doctor
        if (! Auth::check()) {
            return redirect()->route('login');
        }

        if (Auth::user()->role !== 'doctor') {
            abort(403, 'Acceso denegado.');
        }

        return $next($request);
    }
}
