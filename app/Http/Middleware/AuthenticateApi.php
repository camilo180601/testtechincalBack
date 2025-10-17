<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\JWTException;

class AuthenticateApi
{
    public function handle(Request $request, Closure $next)
    {
        try {
            $user = JWTAuth::parseToken()->authenticate(); 
            // Esto arroja excepción si token no está presente o inválido
        } catch (TokenExpiredException $e) {
            return response()->json(['message' => 'Token expirado'], 401);
        } catch (JWTException $e) {
            return response()->json(['message' => 'Token inválido'], 401);
        }

        if (!$user) {
            return response()->json(['message' => 'No autenticado'], 401);
        }

        return $next($request);
    }
}
