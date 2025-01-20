<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    /**
     * Registra un nuevo usuario.
     *
     * @param Request $request La solicitud HTTP que contiene los datos del usuario.
     * @return \Illuminate\Http\JsonResponse Respuesta JSON con el resultado del registro.
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required|string|unique:users|max:50',
            'email' => 'required|email|unique:users|max:100',
            'password' => 'required|string|min:8',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $user = User::create([
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);

        return response()->json(['message' => 'User registered successfully'], 201);
    }

    /**
     * Inicia sesión un usuario existente.
     *
     * @param Request $request La solicitud HTTP que contiene las credenciales del usuario.
     * @return \Illuminate\Http\JsonResponse Respuesta JSON con el token de acceso o error.
     */
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }


        $token = $user->createToken('MyApp')->plainTextToken;

        return response()->json([
            'token' => $token,
            'user' => $user,
        ]);
    }

    /**
     * Cierra sesión al usuario autenticado.
     *
     * @param Request $request La solicitud HTTP que contiene la información del usuario.
     * @return \Illuminate\Http\JsonResponse Respuesta JSON confirmando el cierre de sesión.
     */
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json(['message' => 'Logged out successfully']);
    }
}
