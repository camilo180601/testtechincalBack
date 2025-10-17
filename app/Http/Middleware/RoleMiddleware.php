<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, string $role)
    {

        $user = auth('api')->user();
        if (!$user) {
            return response()->json(['message' => 'No autenticado'], 401);
        }

        if ($user->role === 'viewer') {
            return response()->json(['message' => 'No autorizado'], 403);
        }

        return $next($request);
    }
}
