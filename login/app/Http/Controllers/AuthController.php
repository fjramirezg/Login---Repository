<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
public function login(Request $request)
{
// Validar los datos de entrada
$request->validate([
'username' => 'required|string',
'password' => 'required|string',
]);

// Credenciales fijas
$validUsername = '123';
$validPassword = '456';

// Verificar credenciales
if ($request->username === $validUsername && $request->password === $validPassword) {
// Generar un token
$token = base64_encode(uniqid());

return response()->json([
'message' => 'Login successful',
'token' => $token,
], 200);
}

// Respuesta si las credenciales no coinciden
return response()->json([
'message' => 'Invalid username or password',
], 401);
}
}
