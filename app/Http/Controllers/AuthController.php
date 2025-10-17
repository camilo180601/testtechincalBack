<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $data = $request->validate([
           'email' => 'required|email',
           'password' => 'required'
        ]);

        if (! $token = auth('api')->attempt($data)) {
            return response()->json(['message' => 'Credenciales inválidas'], 401);
        }

        // Access + optionally a refresh token pattern (jwt-auth does not auto-provide refresh by default)
        // We'll return token and expires_in seconds
        $ttl = auth('api')->factory()->getTTL() * 60; // minutes to seconds

        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => $ttl
        ]);
    }

    public function me(Request $request)
    {
        return response()->json(auth('api')->user());
    }

    public function logout(Request $request)
    {
        auth('api')->logout();
        return response()->json(['message' => 'Sesión finalizada']);
    }

    // Optional: refresh token endpoint
    public function refresh()
    {
        try {
            $newToken = auth('api')->refresh();
            $ttl = auth('api')->factory()->getTTL() * 60;
            return response()->json([
                'access_token' => $newToken,
                'token_type' => 'bearer',
                'expires_in' => $ttl
            ]);
        } catch (\Exception $e) {
            return response()->json(['message' => 'No se pudo refrescar token'], 401);
        }
    }
}
