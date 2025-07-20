<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     * Role bisa berupa satu atau lebih (contoh: admin, kasir)
     */
    public function handle($request, Closure $next, ...$roles)
    {
        $user = Auth::user();

        // Cek apakah role user cocok dengan salah satu role yang diizinkan
        if (! $user || ! in_array($user->role, $roles)) {
            abort(403, 'Akses ditolak.');
        }

        return $next($request);
    }
}
