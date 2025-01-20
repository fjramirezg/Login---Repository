<?php

namespace App\Http\Controllers;

use App\Models\UserMod;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function index()
    {
        return UserMod::all();
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:User,user_id',
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $user = UserMod::create([
            'user_id' => $request->user_id,
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);

        return response()->json(['message' => 'Usuario registrado satisfactoriamente'], 201);
    }

    public function show(string $user_id)
    {
        try {
            $Usuario = UserMod::findOrFail($user_id);
            return response()->json($Usuario);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'Usuario no encontrado'], 404);
        }
    }

    public function update(Request $request, string $user_id)
    {
        try {
            // Validación de datos
            $request->validate([
                'user_id' => 'required|exists:users_id',
                'name' => 'required|string',
                'email' => 'required|email|unique:users,email',
                'password' => 'required|string'

            ]);

            // Buscar el clienteMod
            $usuario = UserMod::findOrFail($user_id);

            // Actualizar los datos
            $usuario->update([
                'user_id' => $request->user_id,
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password)

            ]);

            // Retornar respuesta
            return response()->json([
                'message' => 'Usuario actualizado con éxito',
                'usuario' => $usuario
            ], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'Usuario no encontrado'], 404);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Usuario al actualizar clienteMod'], 500);
        }
    }

    public function destroy(string $user_id)
    {
        try {
            // Buscar el clienteMod
            $usuario = UserMod::findOrFail($user_id);

            // Eliminar el clienteMod
            $usuario->delete();

            // Retornar respuesta
            return response()->json([
                'message' => 'Cliente eliminado con éxito'
            ], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'message' => 'Cliente no encontrado'
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al eliminar el clienteMod'
            ], 500);
        }
    }
}
