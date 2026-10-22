<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        if (!in_array(auth()->user()->role, $roles)) {
            if ($request->expectsJson()) {
                return response()->json(['message' => '🚫 AKSES DITOLAK! Hak akses ini khusus untuk Super Admin.'], 403);
            }
            return redirect()->route('dashboard')->with('error', '🚫 AKSES DITOLAK! Sebagai Anggota Staf, Anda hanya diperbolehkan mengelola Informasi Kelurahan & Profil Kelurahan.');
        }

        return $next($request);
    }
}
