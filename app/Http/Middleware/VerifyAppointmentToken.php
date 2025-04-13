<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class VerifyAppointmentToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $clientToken = $request->header('X-Appointment-Token');

        if (! $clientToken) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        $date = $request->route('date');
        // Validar formato de fecha
        if (! preg_match('/^\d{4}-\d{2}-\d{2}$/', $date)) {
            return response()->json(['error' => 'Fecha inválida'], 400);
        }

        $expectedToken = hash_hmac('sha256', 'secure-access', config('app.key'));

        if (! hash_equals($clientToken, $expectedToken)) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        return $next($request);
    }
}
