<?php

namespace App\Http\Middleware;

use Carbon\Carbon;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
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

        try {
            $tokenData = Crypt::decrypt($clientToken);

            // Verificar si el token ha expirado
            if (Carbon::now()->timestamp > $tokenData['expires_at']) {
                return response()->json(['error' => 'Token expired'], 401);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'Invalid token'], 403);
        }

        // Validar formato de fecha
        $date = $request->route('date');
        if (! preg_match('/^\d{4}-\d{2}-\d{2}$/', $date)) {
            return response()->json(['error' => 'Invalid date format'], 400);
        }

        return $next($request);
    }
}
