<?php

namespace App\Http\Controllers;

use App\Models\UserMod;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\validation\Rule;

class UserController extends Controller
{
    public function index()
    {
        return UserMod::all();
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required|string',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string',
            'role' => 'required|string|in:admin,user'

        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $user = UserMod::create([
            'username' => $request->username,//user
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $user->syncRoles([$request->role]);

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
            // Usar la propiedad id
            $esMiUsuario = $request->user()->id == $user_id;

            $request->validate([
                'username' => 'required|string',
                'email'    => ['required', 'email', Rule::unique('users', 'email')->ignore($user_id)],
                'password' => 'nullable|string',
                'role'     => 'required|string|in:admin,user'
            ]);

            $usuario = UserMod::findOrFail($user_id);

            $datosActualizar = [
                'username' => $request->username,
                'email'    => $request->email,
            ];

            if ($request->filled('password')) {
                $datosActualizar['password'] = Hash::make($request->password);
            }

            $usuario->update($datosActualizar);

            // Si no es el mismo usuario, se actualiza el rol
            if (!$esMiUsuario) {
                $usuario->syncRoles([$request->role]);
            }

            return response()->json([
                'message'      => 'Usuario actualizado con éxito',
                'usuario'      => $usuario,
                'rol_cambiado' => !$esMiUsuario,
            ], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'Usuario no encontrado'], 404);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error al actualizar'], 500);
        }
    }



    public function destroy (Request $request, string $user_id)
    {
        try {
            if ($request->user()->id() == $user_id) {
                return response()->json([
                    'message' => 'No puede eliminar este usuario'],
                    404);

            }

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



    //prueba ------------------
    public function getCurrentUserRole()
    {
        $user = auth()->user();

        if (!$user) {
            return response()->json([
                'message' => 'Usuario no autenticado'
            ], 401);
        }

        return response()->json([
            'name' => $user->name,
            'role' => $user->getRoleNames()->first(), // Obtiene el primer rol (admin o user)
            'isAdmin' => $user->hasRole('admin'),
            'isUser' => $user->hasRole('user')
        ]);
    }
    //prueba ------------------

}
