<?php

namespace App\Http\Controllers;

use App\Integration\Database\Post;
use App\Models\cliente;
use Illuminate\Http\Request;

class ClienteController
{

    public function index()
    {
        return response()->json(Post::all());
    }

    public function create()
    {
        return response()->json(['message' => 'Método no utilizado en API'], 200);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'phone' => 'required|integer|max:255',
            'address' => 'required|string|max:255',
        ]);
        $cliente = cliente::create($request->all());
        return response()->json($cliente, 201);
    }
    public function show(string $id)
    {
        $client = cliente::find($id);
        if (!$client) {
            return response()->json(['message' => 'Cliente no encontrado'], 404);
        }

        return response()->json($client, 200);
    }
    public function edit(string $id)
    {
        return response()->json(['message' => 'Método no utilizado en API'], 200);

    }
    public function update(Request $request, string $id)
    {
        $client = cliente::find($id);
        if (!$client) {
            return response()->json(['message' => 'Cliente no encontrado'], 404);
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'phone' => 'required|integer|max:255',
            'address' => 'required|string|max:255',
        ]);
        $client->update($request->all());
        return response()->json($client, 200);
    }
    public function destroy(string $id)
    {
        $client = cliente::find($id);
        if (!$client) {
            return response()->json(['message' => 'Cliente no encontrado'], 404);
        }

        $client->delete();
        return response()->json(['message' => 'Cliente eliminado'], 200);
    }

}
