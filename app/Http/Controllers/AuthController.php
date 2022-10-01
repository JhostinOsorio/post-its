<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;

class AuthController extends Controller
{

    public function login(Request $request)
    {
        try {
            $email = $request->get('email');
            $password = $request->get('password');
    
            if (! $token = auth()->attempt(['email' => $email, 'password' => $password])) {
                return response()->json([
                    'success' => false,
                    'message' => 'Usuario / Contraseña no existe'
                ], 401);
            }
    
            return response()->json([
                'success' => true,
                'message' => 'Ingresaste con éxito',
                'data' => $this->respondWithToken($token)
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }
    
    public function logout()
    {
        try {
            auth()->logout();

            return response()->json([
                'success' => true,
                'message' => 'Cerraste sesión con éxito'
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Ocurrio un problema al cerrar sesión',
            ], 500);
        }
    }

    protected function respondWithToken($token)
    {
        return [
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ];
    }
}
