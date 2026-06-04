<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PermissionMiddleware
{
    public function handle(Request $request, Closure $next, string ...$permissions): Response
    {
        if (!$request->user() || !$request->user()->canAccessAny($permissions)) {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Forbidden: You do not have permission to access this resource.'], 403);
            }

            abort(403, 'Anda tidak memiliki hak akses untuk membuka halaman ini.');
        }

        return $next($request);
    }
}
