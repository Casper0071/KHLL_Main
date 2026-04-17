<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SecurityHeaders
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // Only apply strict CSP in production
        if (app()->isProduction()) {
            $csp = "default-src 'self'; "
                . "script-src 'self' https:; "
                . "style-src 'self' https://fonts.googleapis.com 'nonce-" . $this->getNonce() . "'; "
                . "img-src 'self' data: https:; "
                . "font-src 'self' https://fonts.gstatic.com; "
                . "connect-src 'self' https:; "
                . "frame-ancestors 'none'; "
                . "base-uri 'self'; "
                . "form-action 'self'";

            $response->headers->set('Content-Security-Policy', $csp);
        } else {
            // Development: More permissive to allow Vue dev tools and HMR
            $csp = "default-src 'self' 'unsafe-inline' 'unsafe-eval' https: http: ws: wss:; "
                . "img-src 'self' data: https: http:; "
                . "font-src 'self' data: https:; "
                . "connect-src 'self' https: http: ws: wss:";

            $response->headers->set('Content-Security-Policy', $csp);
        }

        $response->headers->set('X-Content-Type-Options', 'nosniff');
        $response->headers->set('X-Frame-Options', 'SAMEORIGIN');
        $response->headers->set('X-XSS-Protection', '1; mode=block');
        $response->headers->set('Referrer-Policy', 'strict-origin-when-cross-origin');

        return $response;
    }

    /**
     * Generate a nonce for CSP inline scripts
     */
    private function getNonce(): string
    {
        return base64_encode(random_bytes(16));
    }
}

