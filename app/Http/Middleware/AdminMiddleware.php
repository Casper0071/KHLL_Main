<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        // Check of gebruiker is ingelogd
        if (!$request->user()) {
            return response()->json([
                'success' => false,
                'message' => 'Niet ingelogd'
            ], 401);
        }

        // Check of gebruiker admin rol heeft
        if ($request->user()->role !== 'admin') {
            return response()->json([
                'success' => false,
                'message' => 'Geen toegang. Admin rechten vereist.'
            ], 403);
        }

        return $next($request);
    }
}
