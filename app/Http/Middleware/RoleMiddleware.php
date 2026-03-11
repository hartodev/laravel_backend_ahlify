<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        $user = $request->user();

        // jika belum login
        if (!$user) {

            if ($request->expectsJson()) {
                return response()->json([
                    'message' => 'Unauthenticated'
                ], 401);
            }

            return redirect()->route('login');
        }

        // jika role tidak sesuai
        if (!in_array($user->role, $roles)) {

            if ($request->expectsJson()) {
                return response()->json([
                    'message' => 'Forbidden - wrong role'
                ], 403);
            }

            abort(403, 'Forbidden');
        }

        return $next($request);
    }
}
