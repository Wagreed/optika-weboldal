<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckFilamentAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Ha nincs bejelentkezve, továbbítjuk az Authenticate middleware-nek
        if (!auth()->check()) {
            return $next($request);
        }

        $user = auth()->user();

        // Ellenőrizzük hogy admin vagy staff szerepkörrel rendelkezik-e
        if (!$user->hasRole(['admin', 'staff'])) {
            abort(403, 'Nincs jogosultságod az admin panel eléréséhez.');
        }

        return $next($request);
    }
}
