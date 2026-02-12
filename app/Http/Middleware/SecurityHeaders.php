<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * SecurityHeaders Middleware
 * 
 * Menambahkan security headers ke response, termasuk:
 * - Content-Security-Policy (CSP) untuk mencegah inline script/XSS
 * - X-Content-Type-Options untuk mencegah MIME sniffing
 * - X-Frame-Options untuk mencegah clickjacking
 * - X-XSS-Protection sebagai lapisan tambahan
 */
class SecurityHeaders
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // Content Security Policy - Blokir inline script
        $response->headers->set('Content-Security-Policy', 
            "default-src 'self'; " .
            "script-src 'self' https://cdn.jsdelivr.net; " .
            "style-src 'self' 'unsafe-inline' https://cdn.jsdelivr.net https://fonts.googleapis.com; " .
            "font-src 'self' https://cdn.jsdelivr.net https://fonts.gstatic.com; " .
            "img-src 'self' data:; " .
            "connect-src 'self'"
        );

        // Mencegah browser melakukan MIME type sniffing
        $response->headers->set('X-Content-Type-Options', 'nosniff');

        // Mencegah halaman dimuat dalam iframe (anti-clickjacking)
        $response->headers->set('X-Frame-Options', 'DENY');

        // Lapisan tambahan XSS protection (untuk browser lama)
        $response->headers->set('X-XSS-Protection', '1; mode=block');

        return $response;
    }
}
