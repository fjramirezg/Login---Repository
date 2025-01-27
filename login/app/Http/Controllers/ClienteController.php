<?php

namespace App\Http\Controllers;

use App\Integration\Database\Post;
use App\Models\ClienteMod;
use App\Models\UserMod;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class ClienteController
{

    public function index()
    {
        return ClienteMod::all();
    }

    public function store(Request $request)
      {
          $validator = Validator::make($request->all(), [
              'user_id' => 'required|exists:users,id',
              'name' => 'required|string',
              'email' => 'required|email|unique:clientes,email',
              'phone' => 'required|string',
              'address'=> 'required|string',
          ]);

          if ($validator->fails()) {
              return response()->json($validator->errors(), 422);
          }

          $user = ClienteMod::create([
              'user_id' => $request ->user_id,
              'name' => $request->name,
              'email' => $request->email,
              'phone' => $request->phone,
              'address' => $request ->address
          ]);

          return response()->json(['message' => 'cliente registrado satisfactoriamente'], 201);
      }

    public function show(string $user_id)
    {
        try {
            $Cliente = ClienteMod::findOrFail($user_id);
            return response()->json($Cliente);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'Cliente no encontrado'], 404);
        }
    }

    public function update(Request $request, string $user_id)
    {
        try {
            // Validación de datos
            $request->validate([
                'user_id' => 'required|exists:users,id',
                'name' => 'required|string',
                'email' => 'required|email|unique:clientes,email',
                'phone' => 'required|string',
                'address'=> 'nullable|string',
            ]);

            // Buscar el clienteMod
            $cliente = ClienteMod::findOrFail($user_id);

            // Actualizar los datos
            $cliente->update([
                'user_id' => $request ->user_id,
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'address' => $request ->address
            ]);

            // Retornar respuesta
            return response()->json([
                'message' => 'Cliente actualizado con éxito',
                'clienteMod' => $cliente
            ], 200);

        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'Cliente no encontrado'], 404);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error al actualizar clienteMod'], 500);
        }
    }

    public function destroy(string $user_id)
    {
        try {
            // Buscar el clienteMod
            $cliente = ClienteMod::findOrFail($user_id);

            // Eliminar el clienteMod
            $cliente->delete();

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
