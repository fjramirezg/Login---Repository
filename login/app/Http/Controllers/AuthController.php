<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

/**
 * Class AuthController
 *
 * Controlador para la autenticación de usuarios, incluyendo registro,
 * inicio de sesión y cierre de sesión.
 *
 * @package App\Http\Controllers
 */
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
            'first_name' => 'nullable|string|max:50',
            'last_name' => 'nullable|string|max:50',
            'phone_number' => 'nullable|string|max:20',
            'date_of_birth' => 'nullable|date',
            'profile_image' => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $user = User::create([
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'phone_number' => $request->phone_number,
            'date_of_birth' => $request->date_of_birth,
            'profile_image' => $request->profile_image,
            'status' => 'active', // Estado predeterminado
            'last_login' => null,
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

        // Validar si el usuario está activo
        if ($user->status !== 'active') {
            return response()->json(['message' => 'Account is not active'], 403);
        }

        // Actualizar último inicio de sesión
        $user->update(['last_login' => now()]);

        // Crear token
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
